<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this Template file, choose Tools | Templates
 * and open the Template in the editor.
 */

namespace App\Controller;

use Restfull\Error\Exceptions;

/**
 *
 */
class ErrorController extends AppController
{

    /**
     * @param array $param
     *
     * @return void
     * @throws Exceptions
     */
    public function handling(array $param): void
    {
        $traces = $arguments = [];
        for ($a = (count($param['traces']) - 1); $a >= 0; $a--) {
            if ($param['traces'][$a]['function'] === 'call_user_func_array') {
                $param['traces'][$a - 1]['line'] = $this->identifyNextTrace(
                    $param['traces'][$a - 1]['function'],
                    $param['traces'][$a - 2]['file']
                );
                $param['traces'][$a - 1]['file'] = $param['traces'][$a - 2]['file'];
            }
            if (in_array($param['traces'][$a]['function'], ["__construct", "__Construct", 'loadClass']
                ) === false || $a === 0) {
                if (isset($param['traces'][$a]['class']) && isset($param['traces'][$a]['type']) && isset($param['traces'][$a]['function'])) {
                    $line = $param['traces'][$a]['line'];
                    $line--;
                    $function = $param['traces'][$a]['class'] . $param['traces'][$a]['type'] . $param['traces'][$a]['function'];
                    if (!in_array($function, $traces)) {
                        $arguments[$function] = $this->arguments(
                            $line,
                            $param['traces'][$a]['file']
                        );
                    }
                    $traces[] = $function . " - " . $param['traces'][$a]['file'] . ", line: " . $line;
                }
            }
        }
        $this->set('traces', $traces);
        $this->set('msg', $param['msg']);
        $this->set('args', $arguments);
        return;
    }

    /**
     * @param string $method
     * @param string $file
     *
     * @return int
     * @throws Exceptions
     */
    private function identifyNextTrace(string $method, string $file): int
    {
        $arq = $this->instance->resolveClass(
            $this->instance->assemblyClassOrPath(
                '%s' . DS_REVERSE . 'Filesystem' . DS_REVERSE . 'File',
                [ROOT_NAMESPACE[0]]
            ),
            ['file' => $file]
        );
        $file = $arq->read();
        $count = count($file['content']);
        for ($a = 0; $a < $count; $a++) {
            if (stripos($file['content'][$a], $method) !== false) {
                $line = $a + 1;
            }
        }
        return $line;
    }

    /**
     * @param int $line
     * @param string $file
     *
     * @return array
     * @throws Exceptions
     */
    private function arguments(int $line, string $file): array
    {
        $fileRead = $this->instance->read($file, 'file')['content'];
        $linesLimit = $this->validLines($line, $fileRead);
        $numbers = [$line - $linesLimit, $line + ($linesLimit + 1)];
        for ($number = $numbers[0]; $number < $numbers[1]; $number++) {
            if (isset($fileRead[$number])) {
                $lines[$number] = $fileRead[$number];
            }
        }
        return ['line' => $lines, 'identify' => $line];
    }

    /**
     * @param int $line
     * @param array $file
     * @param int $limit
     * @return int
     */
    private function validLines(int $line, array $file, int $limit = 5): int
    {
        $limitResult = $limit;
        if (in_array(($line + $limit), array_keys($file)) === false) {
            $limitResult = $this->validLines($line, $file, $limit - 1);
        }
        return $limitResult;
    }
}