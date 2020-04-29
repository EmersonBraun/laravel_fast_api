<?php
namespace App\Traits;

use Illuminate\Support\Arr;

trait ResponseTrait
{
    /**
     * Mount return.
     *
     * @return array
     */
    public function mountReturn(
        $typeFunction='load', 
        $data, 
        $status=400,
        $contentError=false,
        $showMessage=true,
        $options=0
    )
    {
        $hasError = $this->validateParams($typeFunction, $data, $status, $showMessage);
        if ($hasError) return $this->failedResponse($hasError);

        $happen = $this->getHappen($status);
        $message = $this->getMessage($typeFunction, $happen, $showMessage);
        if ($happen == 'error') return $this->failedResponse($message, $status, $contentError, $options);
        return $this->successResponse($data, $message, $status, $options);
    } 

    /**
     * validateData
     *
     * @return string
     */
    public function validateParams($typeFunction, $data, $status, $showMessage)
    {
        $typesFunctions = ['load','found','create','update','delete' ,'restore','forceDelete'];
        if (!in_array($typeFunction, $typesFunctions)) return "Invalid typeFunction expected ".implode(',',$typesFunctions);
        if (!is_int($status)) return "Invalid status expected Int";
        // if (!is_array($data) || !is_object($data)) return "Invalid data expected Array or Object";
        if (!is_bool($showMessage)) return "Invalid showMessage expected Boolean"; 
        return false;
    }

    /**
     * getHappen
     *
     * @return string
     */
    public function getHappen($status)
    {
        if ($status < 200 || $status >= 300) return 'error';
        return 'success';
    }

    /**
     * getMessage
     *
     * @return string
     */
    public function getMessage($typeFunction, $typeMsg, $showMessage)
    {
        if (!$showMessage) return '';
        $msg = trans("transation.$typeFunction.$typeMsg");
        if ($msg) return $msg;
        return '';
    } 

    /**
     * getContentError
     *
     * @return string
     */
    public function getContentError($contentError)
    {
        if (is_array($contentError)) $contentError = implode(',',Arr::flatten($contentError));
        $content =str_replace(PHP_EOL, ' ', $contentError);
        return $content;
    } 

    /**
     * failedResponse
     *
     * @return string
     */
    public function failedResponse($message='', $status=400, $contentError='', $options=[])
    {
        $content = $this->getContentError($contentError);
        return (object) [
            'data' => [],
            'status' => $status,
            'headers' => [
                'returnType' => 'error',
                'message' => $message,
                'contentError' => $content,
            ],
            'options' => $options
        ];
    }

    /**
     * successResponse
     *
     * @return string
     */
    public function successResponse($data, $message='', $status=200, $options=[])
    {
        return (object) [
            'data' => $data,
            'status' => $status,
            'headers' => [
                'returnType' => 'success',
                'message' => $message,
                'contentError' => null,
            ],
            'options' => $options
        ];
    }
}
