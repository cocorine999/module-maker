<?php

declare(strict_types=1);

namespace LaravelCoreModule\CoreModuleMaker\Helpers\Traits\Responses\Json;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


/**
 * Class ***`ForceRequestResponseToBeJson`***
 *
 * This class provides a utility method to force a JSON response format for the given content.
 *
 * It ensures that the response follows a specified schema, even if the content is not already in JsonResponse format.
 * It can be used to ensure consistent JSON output for API responses,
 * even when the provided content is not already in JsonResponse format.
 *
 * @category ***`LaravelCoreModule\CoreModuleMaker\Helpers`***
 * @package ***`LaravelCoreModule\CoreModuleMaker\Helpers\Traits\RestJson`***
 */
Class ForceRequestResponseToBeJson
{

    /**
     * Force the response to be treated as JSON response with a standard schema.
     *
     * @param HttpResponse $response The response content.
     * @param int          $status   The HTTP status code (default: Response::HTTP_OK).
     * @param array        $headers  The additional response headers (default: []).
     * @param int          $options  The JSON encoding options (default: 0).
     *
     * @return JsonResponse  The JSON response instance.
     */
    public static function force(HttpResponse $response, $status = Response::HTTP_OK, $headers = [], $options = 0): JsonResponse
    {

        // Check if the content is already a JsonResponse instance
        if (!$response instanceof JsonResponse) {

            $content = $response->getOriginalContent();

            $responseContent = self::createResponseContent($content, $status);

            // Create a new JsonResponse instance with the response content
            $response = self::createJsonResponse($responseContent, $status, $headers, $options);
        }else {
            // Check the response schema
            $response = self::checkResponseSchema($response, $status, $headers, $options);
        }

        // Return the JSON response
        return $response;
    }

    /**
     * Check the response schema and update if necessary.
     *
     * @param JsonResponse $response The JsonResponse instance.
     * @param int          $status   The HTTP status code.
     * @param array        $headers  The additional response headers.
     * @param int          $options  The JSON encoding options.
     *
     * @return JsonResponse          The updated JsonResponse instance.
     */
    protected static function checkResponseSchema(JsonResponse $response, $status, $headers, $options): JsonResponse
    {

        $responseData = $response->getOriginalContent();

        // Check if the response data follows the standard schema
        if (!isset($responseData['message']) && !isset($responseData['data']) && !isset($responseData['status_code']) && !isset($responseData['status']))
        {
            $responseContent = self::createResponseContent($responseData, $status);
        }
        else{

            // Determine if the response content is an errors
            $isError = $status >= 400;

            // Check the response schema
            $responseContent = $responseData;

            if (!array_key_exists('message', $responseData))
            {
                $responseContent['message'] = '';
            }
            if (!array_key_exists($isError ? 'errors' : 'data', $responseData))
            {
                $responseContent[$isError ? 'errors' : 'data'] = [];
                unset($responseContent[!$isError ? 'errors' : 'data']);
            }
            if (!array_key_exists('status_code', $responseData))
            {
                $responseContent['status_code'] = $status;
            }
            if (!array_key_exists('status', $responseData))
            {
                $responseContent['status'] = $isError ? false : true;
            }
        }

        // Create a new JsonResponse instance with the response content
        $response = self::createJsonResponse($responseContent, $status, $headers, $options);

        return $response;
    }

    /**
     * Create the response content with the specified schema.
     *
     * @param mixed $content The content to include in the response
     * @param int   $status  The status code (default: Response::HTTP_OK)
     *
     * @return array The response content
     */
    private static function createResponseContent($content, $status = Response::HTTP_OK): array
    {
        // Determine if the response content is an errors
        $isError = $status >= 400;

        $responseContent = [
            'status' => $isError ? false : true,
            'message' => is_string($content) ? $content : '',
            //'data' => is_string($content) ? [] : $content,
            $isError ? 'errors' : 'data' => $isError ? $content : (is_string($content) ? [] : $content),
            'status_code' => $status,
        ];

        return $responseContent;
    }

    /**
     * Create a new JsonResponse instance with the response content.
     *
     * @param array $responseContent The response content
     * @param int   $status          The status code (default: Response::HTTP_OK)
     * @param array $headers         Additional headers (default: [])
     * @param int   $options         JSON encoding options (default: 0)
     *
     * @return JsonResponse The JsonResponse instance
     */
    private static function createJsonResponse(array $responseContent, $status = Response::HTTP_OK, array $headers = [], $options = 0): JsonResponse
    {
        //$response = Response::json($responseContent, $status, $headers, $options);
        $response = JsonResponseTrait::response($responseContent, $status, $headers, $options);

        // Set the 'Content-Type' header to 'application/json'
        $response->header('Content-Type', 'application/json');

        // Set the 'Accept' header to 'application/json'
        $response->header('Accept', 'application/json');

        return $response;
    }

}