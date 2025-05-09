<?php
if (!function_exists('file_icon')) {
    function file_icon($mimeType)
    {
        $icons = [
            'image/' => 'fa-file-image',
            'audio/' => 'fa-file-audio',
            'video/' => 'fa-file-video',
            'application/pdf' => 'fa-file-pdf',
            'application/msword' => 'fa-file-word',
            'application/vnd.ms-excel' => 'fa-file-excel',
            'application/vnd.ms-powerpoint' => 'fa-file-powerpoint',
            'application/zip' => 'fa-file-archive',
            'text/' => 'fa-file-alt',
        ];

        foreach ($icons as $pattern => $icon) {
            if (str_starts_with($mimeType, $pattern)) {
                return $icon;
            }
        }

        return 'fa-file';
    }
}
