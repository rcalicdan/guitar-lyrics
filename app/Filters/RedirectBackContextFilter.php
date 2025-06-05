<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class RedirectBackContextFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = Services::session();
        $logger = Services::logger(); // Or your get_logger() helper

        // Session keys defined in your helper or constants file
        $pendingTokenKey = '_rb_pending_token_for_next_hop'; // Or use defined(RB_PENDING_TOKEN_KEY) ? RB_PENDING_TOKEN_KEY : '...'
        $activeTokenKey = '_rb_active_token_for_current_context'; // Or use defined(RB_ACTIVE_TOKEN_KEY) ? RB_ACTIVE_TOKEN_KEY : '...'

        if ($session->has($pendingTokenKey)) {
            $pendingToken = $session->get($pendingTokenKey);
            $session->set($activeTokenKey, $pendingToken);
            $session->remove($pendingTokenKey); // Consume the pending token
            $logger->debug("[RB_FILTER] Activated redirect-back token '{$pendingToken}' for current context.");
        } else {
            // If no new pending token was set for this hop, it means the user likely navigated
            // directly or the previous page didn't establish a back context.
            // Clear any old active token to ensure a clean state for fallbacks.
            if ($session->has($activeTokenKey)) {
                $session->remove($activeTokenKey);
                $logger->debug('[RB_FILTER] No new pending token. Cleared previous active redirect-back token.');
            } else {
                $logger->debug('[RB_FILTER] No new pending token and no active token to clear.');
            }
        }

        return $request; // Must return the request object
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after response is sent
        return $response; // Must return the response object
    }
}
