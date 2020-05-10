<?php
require __DIR__ . '/vendor/autoload.php';
use Google\Cloud\Storage\StorageClient;

class storage {
  private $projectId;
  private $storage;
    public function __construct() {
        putenv("GOOGLE_APPLICATION_CREDENTIALS=/var/www/html/credentials/learnWebCoding-636c1b188316.json");
        $this->projectId = 'learnwebcoding';
        $this->storage = new StorageClient([
            'projectId' => $this->projectId
        ]);
        $this->storage->registerStreamWrapper();
    }

    public function createBucket($bucketName) {
        $bucket = $this->storage->createBucket($bucketName);
        echo 'Bucket ' . $bucket->name() . ' created.';
    }

    public function listBuckets() {
        $buckets = $this->storage->buckets();
        foreach ($buckets as $bucket) {
            echo $bucket->name() . PHP_EOL;
        }
    }

    function uploadObject($bucketName, $objectName, $source) {
        $file = fopen($source, 'r');
        $bucket = $this->storage->bucket($bucketName);
        $object = $bucket->upload($file, [
            'name' => $objectName
        ]);
        printf('Uploaded %s to gs://%s/%s' . PHP_EOL, basename($source), $bucketName, $objectName);
    }

    function listObjects($bucketName) {
        $bucket = $this->storage->bucket($bucketName);
        foreach ($bucket->objects() as $object) {
            printf('Object: %s' . '<br>', $object->name());
        }
    }
    function deleteObject($bucketName, $objectName, $options = []) {
        $bucket = $this->storage->bucket($bucketName);
        $object = $bucket->object($objectName);
        $object->delete();
        printf('Deleted gs://%s/%s' . PHP_EOL, $bucketName, $objectName);
    }

    function deleteBucket($bucketName) {
        $bucket = $this->storage->bucket($bucketName);
        $bucket->delete();
        printf('Deleted gs://%s' . PHP_EOL, $bucketName);
    }

    function downloadObject($bucketName, $objectName, $destination) {
        $bucket = $this->storage->bucket($bucketName);
        $object = $bucket->object($objectName);
        $object->downloadToFile($destination);
        printf('Downloaded gs://%s/%s to %s' . PHP_EOL,
            $bucketName, $objectName, basename($destination));
    }
    function getImageUrl($bucketName, $objectName) {
        return 'https://storage.cloud.google.com/'.$bucketName.'/'.$objectName;
    }
}