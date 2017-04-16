<?php

/**
 * Date: 15.04.17
 * Time: 10:56
 * @Author Vasiliy Pyatykh
 */
class Storage
{

    private $storage;

    public function __construct()
    {

        $this->storage = [];


        $item = [
            'result' => true,
            'img' => 'http://aquamaris.ru/pictures/png_pic_16.png',
            'name' => 'Аква Марис Норм 150мл спрей',
            'desc' => 'Средство на основе натуральной воды Адриатического моря для лечения насморка, 
    который сопровождается обильными выделениями из носа у взрослых и детей с  2-х лет.',
            'ttl' => date(DATE_RFC3339, 1483228800),
        ];

        $this->insert($item);
    }

    /**
     * @param $originalQRText
     * @return array|null
     */
    public function lookUp($originalQRText)
    {

        $primaryKey = $this->decrypt($originalQRText);
        if (isset($this->storage[$primaryKey])) {
            return $this->storage[$primaryKey];
        } else {
            return null;
        }
    }

    /**
     * @param $itemData
     * @return string encrypted key (safe for QR code)
     */
    public function insert($itemData)
    {
        $primaryKey = $this->generatePrimaryKey($itemData);
        $this->storage[$primaryKey] = $itemData;

        return $this->encrypt($primaryKey);

    }

    private function encrypt($originalString)
    {

        return $originalString; // todo encryption
    }

    private function decrypt($originalText)
    {

        return $originalText; // todo decryption
    }

    /**
     * @param $itemData
     * @return string
     */
    private function generatePrimaryKey($itemData)
    {
        srand(100500);
        return rand(1, 1000000) . sha1(serialize($itemData)); // todo improve security 9000x times, work around possible duplicates
    }
}

$storage = new Storage();
$originalQRText = str_replace('/', '', $_SERVER['REQUEST_URI']);
$data = $storage->lookUp($originalQRText);

header('Content-type: application/json; charset=utf-8');
if ($data) {
    echo json_encode($data);
} else {
    echo json_encode(['result' => false]);
}


