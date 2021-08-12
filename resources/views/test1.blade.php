@php


$fp = fopen('F:\xampp\htdocs\seo\public\user_profile\1628076151.prod-1.jpg', 'rb');
  
// Read the exif headers
$headers = exif_read_data($fp);
  @foreach($header as $data)
// Print the headers
echo 'EXIF Headers:' . '<br>';
  dd($data);
  @endforeach
print("<pre>".print_r($headers, true)."</pre>");

@endphp