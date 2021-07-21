<?php

declare(strict_types=1);

namespace Tests;

use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Config;
use BladeUI\Icons\BladeIconsServiceProvider;
use Codeat3\BladeGovIcons\BladeGovIconsServiceProvider;

class CompilesIconsTest extends TestCase
{
    /** @test */
    public function it_compiles_a_single_anonymous_component()
    {
        $result = svg('govicon-book')->toHtml();

        // Note: the empty class here seems to be a Blade components bug.
        $expected = <<<'SVG'
            <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor"><title>book</title><path d="M55.94,9.12V48.94H19.19a3.07,3.07,0,0,1,0-6.13H52.88V3H19.19a6.13,6.13,0,0,0-6.13,6.12V45.87A6.13,6.13,0,0,0,19.19,52H59V9.12Z"/></svg>
            SVG;


        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_classes_to_icons()
    {
        $result = svg('govicon-book', 'w-6 h-6 text-gray-500')->toHtml();
        $expected = <<<'SVG'
            <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor"><title>book</title><path d="M55.94,9.12V48.94H19.19a3.07,3.07,0,0,1,0-6.13H52.88V3H19.19a6.13,6.13,0,0,0-6.13,6.12V45.87A6.13,6.13,0,0,0,19.19,52H59V9.12Z"/></svg>
            SVG;
        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_styles_to_icons()
    {
        $result = svg('govicon-book', ['style' => 'color: #555'])->toHtml();


        $expected = <<<'SVG'
            <svg style="color: #555" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor"><title>book</title><path d="M55.94,9.12V48.94H19.19a3.07,3.07,0,0,1,0-6.13H52.88V3H19.19a6.13,6.13,0,0,0-6.13,6.12V45.87A6.13,6.13,0,0,0,19.19,52H59V9.12Z"/></svg>
            SVG;

        $this->assertSame($expected, $result);
    }

    /** @test */
    public function it_can_add_default_class_from_config()
    {
        Config::set('blade-govicons.class', 'awesome');

        $result = svg('govicon-book')->toHtml();

        $expected = <<<'SVG'
            <svg class="awesome" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor"><title>book</title><path d="M55.94,9.12V48.94H19.19a3.07,3.07,0,0,1,0-6.13H52.88V3H19.19a6.13,6.13,0,0,0-6.13,6.12V45.87A6.13,6.13,0,0,0,19.19,52H59V9.12Z"/></svg>
            SVG;

        $this->assertSame($expected, $result);

    }

    /** @test */
    public function it_can_merge_default_class_from_config()
    {
        Config::set('blade-govicons.class', 'awesome');

        $result = svg('govicon-book', 'w-6 h-6')->toHtml();

        $expected = <<<'SVG'
            <svg class="awesome w-6 h-6" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 72 56" fill="currentColor"><title>book</title><path d="M55.94,9.12V48.94H19.19a3.07,3.07,0,0,1,0-6.13H52.88V3H19.19a6.13,6.13,0,0,0-6.13,6.12V45.87A6.13,6.13,0,0,0,19.19,52H59V9.12Z"/></svg>
            SVG;

        $this->assertSame($expected, $result);

    }

    protected function getPackageProviders($app)
    {
        return [
            BladeIconsServiceProvider::class,
            BladeGovIconsServiceProvider::class,
        ];
    }
}
