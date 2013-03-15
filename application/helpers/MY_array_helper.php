<?php 

function array_filter_recursive($haystack)
{
    foreach ($haystack as $key => $value) {

      if (is_array($value)) {
          $haystack[$key] = array_filter_recursive($haystack[$key]);
      }

      if (empty($haystack[$key])) {
          unset($haystack[$key]);
      }

    }

    return $haystack;
    
} 