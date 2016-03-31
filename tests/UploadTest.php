<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UploadTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFileUpload()
    {
        $filePath = base_path('tests/tmp/image.jpg');

        $file = new \Illuminate\Http\UploadedFile(
            $filePath,
            basename($filePath),
            'image/jpeg',
            File::size($filePath)
        );

        $response = $this->call('POST', 'upload/image', [], [], [], [
            'HTTP_X_FILE_NAME' => 'image.jpg'
        ], file_get_contents($file));

        $this->assertResponseOk();
        $this->assertResponseStatus(200);
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);

        $this->assertTrue(is_array($responseData));
        $this->assertArrayHasKey('file', $responseData);
        $this->assertArrayHasKey('name', $responseData);
        $this->assertArrayHasKey('content_type', $responseData);
        $this->assertArrayHasKey('size', $responseData);
    }
}
