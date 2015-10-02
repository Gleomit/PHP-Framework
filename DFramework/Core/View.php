<?php

namespace DF\Core;

class View
{
    const VIEW_FOLDER = 'Views';
    const VIEW_EXTENSION = '.php';

    public function __construct($filePath, $model, $escapeOutput = true){
        $fullFilePath = self::VIEW_FOLDER . '\\' . $filePath . self::VIEW_EXTENSION;

        $this->checkExpectedModel($fullFilePath, $model);

        if($escapeOutput === true) {
            $model = $this->escapeOutput($model);
        }

        require $fullFilePath;
    }

    private function checkExpectedModel($file, $model) {
        $contents = file_get_contents($file);
        $rows = explode("\n", $contents);
        $modelTypeAnnotation = $rows[0];

        preg_match_all("/([A-Z])\w+/", $modelTypeAnnotation, $matches);
        $expectedType = implode('\\', $matches[0]);

        if(!empty($expectedType)) {
            if(!isset($model) || is_array($model)) {
                throw new \Exception("Invalid type, expects class!");
            }

            if(get_class($model) != $expectedType) {
                throw new \Exception("Invalid type of ViewModel!");
            }
        }
    }

    private function escapeOutput($toEscape) {
        if(is_array($toEscape)) {
            foreach ($toEscape as $key => &$value) {
                if(is_object($value)) {
                    $reflection = new \ReflectionClass($value);
                    $properties = $reflection->getProperties();

                    foreach ($properties as &$property) {
                        $property->setAccessible(true);
                        $property->setValue($value, $this->escapeOutput($property->getValue($value)));
                    }
                } elseif(is_array($value)) {
                    $this->escapeOutput($value);
                } else {
                    $value = htmlspecialchars($value);
                }
            }
        } elseif(is_object($toEscape)) {
            $reflection = new \ReflectionClass($toEscape);
            $properties = $reflection->getProperties();

            foreach ($properties as &$property) {
                $property->setAccessible(true);
                $property->setValue($toEscape, $this->escapeOutput($property->getValue($toEscape)));
            }
        } else {
            $toEscape = htmlspecialchars($toEscape);
        }

        return $toEscape;
    }
}