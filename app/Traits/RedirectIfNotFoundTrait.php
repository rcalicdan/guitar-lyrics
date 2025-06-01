<?php

namespace App\Traits;

use CodeIgniter\Exceptions\PageNotFoundException;

trait RedirectIfNotFoundTrait
{
    /**
     * Redirects back to the previous page with error message if the given resource is not found.
     * @param string $recordName The display name of the resource to use in the error message. Defaults to 'Record'
     */
    public function redirectBackIfNotFound($resource, string $recordName = 'Record')
    {
        if (!$resource) {
            $response = redirect()->back()->with('error', "{$recordName} not found");
            $response->send();
            exit;
        }

        return $resource;
    }

    /**
     * Redirects back to the previous page with error message if the given resource is not found.
     * @param string $recordName The display name of the resource to use in the error message. Defaults to 'Record'
     */
    public function redirectBack404IfNotFound($resource, string $recordName = 'Record')
    {
        if (!$resource) {
            throw PageNotFoundException::forPageNotFound("{$recordName} not found");
        }

        return $resource;
    }
}
