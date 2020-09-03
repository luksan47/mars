<?php

namespace Tests\Unit;

use Tests\TestCase;

class LocaleTest extends TestCase
{
    /**
     * This test is to ensure the assumption that hungarian and english translations are always present for every key.
     *
     * @return void
     */
    public function testEnglishHungarianConsistency()
    {
        $en_files = array_diff(scandir(base_path('resources/lang/en')), ['..', '.']);
        $hu_files = array_diff(scandir(base_path('resources/lang/en')), ['..', '.']);
        // We can't assume the order of the files.
        sort($en_files);
        sort($hu_files);
        // Having the same files for both locales.
        $this->assertEquals($en_files, $hu_files);
        foreach ($en_files as $file_in) {
            $en_expressions = require base_path('resources/lang/en/'.$file_in);
            $hu_expressions = require base_path('resources/lang/hu/'.$file_in);
            $en_keys = array_keys($en_expressions);
            $hu_keys = array_keys($hu_expressions);
            // Having the same keys in each file for both locales.
            $this->assertEquals($en_keys, $hu_keys);
            // Having the same keys in validation.attributes for both locales.
            if($file_in == 'validation.php') {
                $this->assertEquals(array_keys($en_expressions['attributes']), array_keys($hu_expressions['attributes']));
            }
        }
    }

    /**
     * This test is to ensure that hungarian and english locale keys do not contain any point.
     *
     * @return void
     */
    public function testLocaleKeyFormats()
    {
        foreach (['hu', 'en'] as $lang){
            $files = array_diff(scandir(base_path('resources/lang/'.$lang)), ['..', '.']);
            foreach ($files as $file) {
                $expressions = require base_path('resources/lang/'.$lang.'/'.$file);
                foreach ($expressions as $key => $value) {
                    $this->assertFalse(strpos($key, '.'));
                    if($file == 'validation.php') {
                        foreach ($expressions['attributes'] as $key2 => $value2) {
                            $this->assertFalse(strpos($key2, '.'));
                        }
                    }
                }
            }
        }
    }
}
