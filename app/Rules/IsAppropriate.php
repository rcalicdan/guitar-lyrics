<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\RequestException;
use stdClass;
use Throwable;

class IsAppropriate implements ValidationRule
{
    /**
     * The threshold score (0.0 to 1.0) above which the validation fails.
     */
    protected float $threshold;

    /**
     * The Perspective API attribute to check (e.g., TOXICITY, SEVERE_TOXICITY, INSULT).
     */
    protected string $attributeToCheck;

    /**
     * Create a new rule instance.
     *
     * @param  float  $threshold  The threshold score (default: 0.7).
     * @param  string  $attributeToCheck  The Perspective API attribute (default: TOXICITY).
     */
    public function __construct(float $threshold = 0.7, string $attributeToCheck = 'TOXICITY')
    {
        $this->threshold = max(0.0, min(1.0, $threshold));
        $this->attributeToCheck = strtoupper($attributeToCheck);
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute  The attribute name being validated (e.g., 'comment_text').
     * @param  mixed  $value  The value of the attribute (the text to check).
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail  The failure callback.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->shouldSkipValidation($value)) {
            return;
        }

        $apiKey = $this->getApiKey();
        if (empty($apiKey)) {
            $this->logConfigError();
            $fail('The :attribute could not be checked due to a server configuration error.');

            return;
        }

        try {
            $apiUrl = $this->buildApiUrl($apiKey);
            $requestData = $this->prepareRequestData($value);
            $response = $this->makeApiRequest($apiUrl, $requestData);

            if (! $response->successful()) {
                $this->handleFailedResponse($response, $fail);

                return;
            }

            $data = $response->json();
            $score = $this->extractScoreFromResponse($data);

            if ($score === null || ! is_numeric($score)) {
                $this->logResponseFormatError($response);
                $fail('The :attribute verification resulted in an unexpected format.');

                return;
            }

            $this->validateAgainstThreshold((float) $score, $fail);

        } catch (RequestException $e) {
            $this->logRequestError($e);
            $fail('The :attribute could not be verified due to a network issue.');
        } catch (Throwable $e) {
            $this->logUnexpectedError($e);
            $fail('An unexpected error occurred while validating the :attribute.');
        }
    }

    /**
     * Determine if validation should be skipped.
     */
    private function shouldSkipValidation(mixed $value): bool
    {
        return ! is_string($value) || trim($value) === '';
    }

    /**
     * Get API key from environment.
     */
    private function getApiKey(): ?string
    {
        return env('PERSPECTIVE_API_KEY');
    }

    /**
     * Log configuration error.
     */
    private function logConfigError(): void
    {
        log_message('error', '[Validation] Perspective API key (PERSPECTIVE_API_KEY) is not configured in .env file.');
    }

    /**
     * Build the API URL with key.
     */
    private function buildApiUrl(string $apiKey): string
    {
        return "https://commentanalyzer.googleapis.com/v1alpha1/comments:analyze?key={$apiKey}";
    }

    /**
     * Prepare request data for the API call.
     */
    private function prepareRequestData(string $value): array
    {
        return [
            'comment' => ['text' => $value],
            'languages' => ['en'],
            'requestedAttributes' => [
                $this->attributeToCheck => new stdClass,
            ],
            'doNotStore' => true,
        ];
    }

    /**
     * Make the API request.
     */
    private function makeApiRequest(string $apiUrl, array $requestData)
    {
        return http()
            ->timeout(3)
            ->asJson()
            ->acceptJson()
            ->post($apiUrl, $requestData);
    }

    /**
     * Handle failed API response.
     */
    private function handleFailedResponse($response, Closure $fail): void
    {
        $errorBody = $response->json();
        $errorMessage = $errorBody['error']['message'] ?? 'Unknown API error';
        log_message('error', "[Validation] Perspective API request failed with status {$response->status()}: {$errorMessage}. Body: ".$response->body());
        $fail('The :attribute could not be verified due to an API issue.');
    }

    /**
     * Extract score from API response.
     */
    private function extractScoreFromResponse(array $data)
    {
        $scorePath = "attributeScores.{$this->attributeToCheck}.summaryScore.value";

        return $this->arrayGet($data, $scorePath);
    }

    /**
     * Log response format error.
     */
    private function logResponseFormatError($response): void
    {
        log_message('error', "[Validation] Perspective API response format error or score not found for attribute '{$this->attributeToCheck}'. Body: ".$response->body());
    }

    /**
     * Validate the score against threshold.
     */
    private function validateAgainstThreshold(float $score, Closure $fail): void
    {
        if ($score >= $this->threshold) {
            $fail("The :attribute was flagged as potentially inappropriate (score: {$score}).");
        }
    }

    /**
     * Log request error.
     */
    private function logRequestError(RequestException $e): void
    {
        log_message('error', '[Validation] Perspective API request error (Illuminate\Http): '.$e->getMessage());
    }

    /**
     * Log unexpected error.
     */
    private function logUnexpectedError(Throwable $e): void
    {
        log_message('error', '[Validation] Unexpected error during Perspective API validation: '.$e->getMessage().' in '.$e->getFile().' on line '.$e->getLine());
    }

    /**
     * Helper function to safely get a value from a nested array using dot notation.
     * (Similar to Laravel's data_get helper)
     */
    private function arrayGet(?array $array, ?string $key, mixed $default = null): mixed
    {
        if (is_null($key) || trim($key) === '' || is_null($array)) {
            return $default;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }
}
