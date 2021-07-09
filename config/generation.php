<?php

use Codeat3\BladeIconGeneration\IconProcessor;
use RenatoMarinho\LaravelPageSpeed\Middleware\CollapseWhitespace;

$svgNormalization = static function (string $tempFilepath, array $iconSet) {

    // perform generic optimizations
    $iconProcessor = new IconProcessor($tempFilepath, $iconSet);
    $iconProcessor
        ->optimize()
        ->postOptimizationAsString(function ($svgLine){
            $svgLine = (new CollapseWhitespace())->apply($svgLine);
            $replaceMap = [
                '/\<style.*\>.*\<\/style\>/' => '',
                '/\s(class=\"[a-z0-9A-Z]+\")/' => '',
            ];
            return preg_replace(array_keys($replaceMap), array_values($replaceMap), $svgLine);
        })
        ->save();

};

return [
    [
        // Define a source directory for the sets like a node_modules/ or vendor/ directory...
        'source' => __DIR__.'/../dist/raw-svg/',

        // Define a destination directory for your icons. The below is a good default...
        'destination' => __DIR__.'/../resources/svg',

        // Enable "safe" mode which will prevent deletion of old icons...
        'safe' => true,

        // Call an optional callback to manipulate the icon
        // with the pathname of the icon and the settings from above...
        'after' => $svgNormalization,

        'is-solid' => true,

    ],
];
