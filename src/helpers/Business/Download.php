<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper\Business;

use Zf\Helper\Exceptions\ParameterException;

/**
 * 文件下载类
 *
 * Class Download
 * @package Zf\Helper\Business
 */
class Download
{
    /**
     * 文件下载
     *
     * @param string $path
     * @param string|null $downloadName
     *
     * @throws ParameterException
     */
    public static function file(string $path, string $downloadName = null)
    {
        if (!file_exists($path)) {
            throw new ParameterException(interpolate('找不到需要下载的文件"{file}"', [
                'file' => $path,
            ]), 1010007001);
        }
        if (empty($downloadName)) {
            $downloadName = pathinfo($path, PATHINFO_BASENAME);
        }
        $file = fopen($path, "rb");
        Header("Content-type: application/octet-stream");
        Header("Accept-Ranges: bytes");
        Header("Content-Disposition: attachment;filename={$downloadName}");
        $contents = "";
        while (!feof($file)) {
            $contents .= fread($file, 8192);
        }
        echo $contents;
        fclose($file);
    }
}