<?php

namespace WhichBrowser;

class Tests
{
    public static function getAll()
    {
        return glob(__DIR__ . '/../data/*/*.yaml');
    }

    public static function getFromCategory($category)
    {
        return glob(__DIR__ . '/../data/' . $category . '/*.yaml');
    }
}
