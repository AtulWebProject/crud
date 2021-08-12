@php

$size = getimagesize( '../public/user_profile_image/t.jpg', $iptch );

$iptc = isset( $iptch['APP13'] ) ? iptcparse( $iptch['APP13'] ) : false;
$name = isset( $iptc['2#005'] ) ? $iptc['2#005'][0] : 'Undefined';
print "<pre>";
      print_r($name);
    print"</pre>";
    exit;

@endphp