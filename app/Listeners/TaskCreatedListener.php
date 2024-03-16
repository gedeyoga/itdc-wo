<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Str;

class TaskCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle( TaskCreated $event)
    {
        $this->generateQrcode($event->task);   
    }

    protected function generateQrcode(Task $task)
    {
        // $d = new DNS2D();
        // $data = $d->getBarcodePNG(route('work-order.scan') . '?task_id=' . $task->id, 'QRCODE', 25, 25);

        // $task->addMediaFromBase64($data)->usingFileName(Str::uuid())->toMediaCollection('barcode');

        $d = new DNS2D();
        $barcode_data = route('work-order.scan') . '?task_id=' . $task->id;

        // Generate barcode
        $data = $d->getBarcodePNG($barcode_data, 'QRCODE', 25, 25);

        $data = base64_decode($data);

        // Create image resource from barcode data
        $barcode_image = imagecreatefromstring($data);

        // Get barcode image dimensions
        $barcode_width = imagesx($barcode_image);
        $barcode_height = imagesy($barcode_image);

        // Create new image with white background and padding
        $new_width = $barcode_width + 40; // Adjust padding as needed
        $new_height = $barcode_height + 40; // Adjust padding as needed
        $white_bg = imagecreatetruecolor($new_width, $new_height);
        $white = imagecolorallocate($white_bg, 255, 255, 255);
        imagefill($white_bg, 0, 0, $white);

        // Calculate position to center barcode
        $x_offset = ($new_width - $barcode_width) / 2;
        $y_offset = ($new_height - $barcode_height) / 2;

        // Copy barcode onto white background with padding
        imagecopy($white_bg, $barcode_image, $x_offset, $y_offset, 0,
            0,
            $barcode_width,
            $barcode_height
        );

        // Convert image resource to base64 string
        ob_start();
        imagepng($white_bg);
        $final_image_data = ob_get_clean();

        // Save image
        $task->addMediaFromBase64(base64_encode($final_image_data))->usingFileName(Str::uuid())->toMediaCollection('barcode');

        // Free up memory
        imagedestroy($barcode_image);
        imagedestroy($white_bg);
    }
}
