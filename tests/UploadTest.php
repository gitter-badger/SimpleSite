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
        /** @var \App\User $user */
        $user = factory(\App\User::class)->create();
        $user->assignRoles(\App\Role::ROLE_ADMIN);

        $this->actingAs($user);

        $filePath = base_path('tests/tmp/image.jpg');

        $file = new \Illuminate\Http\UploadedFile(
            $filePath,
            basename($filePath),
            'image/jpeg',
            File::size($filePath)
        );

        $response = $this->call('POST', 'upload/image', [], [], [
            'file' => $file
        ]);

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
