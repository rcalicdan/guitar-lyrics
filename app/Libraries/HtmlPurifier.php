<?php

namespace App\Libraries;

class HtmlPurifier
{
    /**
     * Default configuration settings
     * 
     * @var array
     */
    protected static $defaultConfig = [
        'HTML.Allowed' => 'p,b,i,u,strong,em,a[href|title],ul,ol,li,br,span[style],div[class],h1,h2,h3,h4,h5,h6,blockquote,code,pre,img[src|alt|width|height]',
        'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,color,background-color,text-align',
        'AutoFormat.AutoParagraph' => false,
        'AutoFormat.RemoveEmpty' => true,
    ];
    
    /**
     * @var \HTMLPurifier
     */
    protected $purifier;
    
    /**
     * Constructor for instance usage
     *
     * @param array $customConfig Custom configuration settings
     */
    public function __construct(array $customConfig = [])
    {
        $config = array_merge(self::$defaultConfig, $customConfig);
        $purifierConfig = \HTMLPurifier_Config::createDefault();
        
        foreach ($config as $key => $value) {
            $purifierConfig->set($key, $value);
        }
        
        $this->purifier = new \HTMLPurifier($purifierConfig);
    }
    
    /**
     * Clean HTML content (instance method)
     *
     * @param string|null $dirtyHtml HTML content to purify
     * @return string|null Purified HTML or null if input was null
     */
    public function clean(?string $dirtyHtml): ?string
    {
        if ($dirtyHtml === null) {
            return null;
        }
        
        return $this->purifier->purify($dirtyHtml);
    }
    
    /**
     * Static method to quickly clean HTML content
     *
     * @param string|null $dirtyHtml HTML content to purify
     * @param array $customConfig Optional custom configuration
     * @return string|null Purified HTML or null if input was null
     */
    public static function purify(?string $dirtyHtml, array $customConfig = []): ?string
    {
        if ($dirtyHtml === null) {
            return null;
        }
        
        $purifier = new self($customConfig);
        return $purifier->clean($dirtyHtml);
    }
    
    /**
     * Static method to quickly clean an array of HTML content
     *
     * @param array|null $dirtyHtmlArray Array of HTML strings to purify
     * @param array $customConfig Optional custom configuration
     * @return array|null Array of purified HTML strings or null if input was null
     */
    public static function purifyArray(?array $dirtyHtmlArray, array $customConfig = []): ?array
    {
        if ($dirtyHtmlArray === null) {
            return null;
        }
        
        $purifier = new self($customConfig);
        $cleanArray = [];
        
        foreach ($dirtyHtmlArray as $key => $value) {
            if (is_string($value)) {
                $cleanArray[$key] = $purifier->clean($value);
            } elseif ($value === null) {
                $cleanArray[$key] = null;
            } else {
                $cleanArray[$key] = $value;
            }
        }
        
        return $cleanArray;
    }
}