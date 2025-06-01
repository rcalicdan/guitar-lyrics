<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\RequestException;
use Throwable;

class NoObsceneWord implements ValidationRule
{
    private const API_TIMEOUT = 10;
    private const API_ENDPOINT_PATH = '/bad-word-filter';
    private const CENSOR_CHARACTER = '*';

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute The attribute name being validated.
     * @param  mixed   $value     The value of the attribute.
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail The failure callback.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $apiConfig = $this->getApiConfiguration();
        if (!$apiConfig) {
            log_message('error', '[Validation] Bad Word Filter API key or host is not configured in .env file.');
            $fail("The :attribute could not be checked due to a configuration error.");
            return;
        }

        try {
            $response = $this->makeApiRequest($value, $apiConfig);

            if (!$response->successful()) {
                log_message('error', "[Validation] Bad Word Filter API request failed with status {$response->status()}: " . $response->body());
                $fail("The :attribute could not be verified at this time.");
                return;
            }

            $data = $response->json();
            if (!$this->isValidResponseFormat($data)) {
                log_message('error', "[Validation] Bad Word Filter API response format error or JSON decode failed: " . $response->body());
                $fail("The :attribute verification resulted in an unexpected format.");
                return;
            }

            if ($data['is-bad'] === true) {
                $fail('The :attribute contains potentially offensive language.');
            }
        } catch (RequestException $e) {
            log_message('error', '[Validation] Bad Word Filter API request error (Illuminate\Http): ' . $e->getMessage());
            $fail("The :attribute could not be verified due to a network issue.");
        } catch (Throwable $e) {
            log_message('error', '[Validation] Unexpected error during bad word validation: ' . $e->getMessage() .
                ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            $fail("An unexpected error occurred while validating the :attribute.");
        }
    }

    /**
     * Get API configuration from environment variables.
     * 
     * @return array|null Returns API configuration or null if missing.
     */
    private function getApiConfiguration(): ?array
    {
        $apiKey = env('RAPIDAPI_BAD_WORD_KEY');
        $apiHost = env('RAPIDAPI_BAD_WORD_HOST');

        if (empty($apiKey) || empty($apiHost)) {
            return null;
        }

        return [
            'key' => $apiKey,
            'host' => $apiHost,
            'url' => "https://{$apiHost}" . self::API_ENDPOINT_PATH,
        ];
    }

    /**
     * Make the API request to check for obscene words.
     */
    private function makeApiRequest(string $value, array $apiConfig)
    {
        return http()
            ->timeout(self::API_TIMEOUT)
            ->asForm()
            ->withHeaders([
                'x-rapidapi-host' => $apiConfig['host'],
                'x-rapidapi-key' => $apiConfig['key'],
            ])
            ->post($apiConfig['url'], [
                'content' => $value,
                'censor-character' => self::CENSOR_CHARACTER,
            ]);
    }

    /**
     * Check if the API response has the expected format.
     */
    private function isValidResponseFormat(?array $data): bool
    {
        return $data !== null && isset($data['is-bad']);
    }
}
