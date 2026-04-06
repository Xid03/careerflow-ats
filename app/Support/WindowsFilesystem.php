<?php

namespace App\Support;

use Illuminate\Filesystem\Filesystem;

class WindowsFilesystem extends Filesystem
{
    public function replace($path, $content, $mode = null): void
    {
        clearstatcache(true, $path);

        $path = realpath($path) ?: $path;
        // Local Windows setups can reject Laravel's atomic rename step for
        // compiled Blade files. A direct locked write is less elegant, but
        // much more reliable for development on this machine.
        file_put_contents($path, $content, LOCK_EX);

        if (! is_null($mode)) {
            @chmod($path, $mode);
        }
    }
}
