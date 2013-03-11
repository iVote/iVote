<?php 

function array_filter_recursive($haystack)
{
    foreach ($haystack as $key => $value) {

      if (is_array($value)) {
          $haystack[$key] = array_filter_recursive($haystack[$key]);
      }

      array_filter($haystack[$key], "strlen");

    }

    return $haystack;
    
} 