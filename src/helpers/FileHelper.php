<?php
/**
 * @link        http://www.phpcorner.net
 * @author      qingbing<780042175@qq.com>
 * @copyright   Chengdu Qb Technology Co., Ltd.
 */

namespace Zf\Helper;

use Zf\Helper\Exceptions\Exception;

/**
 * 文件目录处理
 *
 * Class FileHelper
 * @package Zf\Helper
 */
class FileHelper
{
    /**
     * 拷贝文件
     *
     * @param string $src 拷贝源
     * @param string $dst 拷贝目标
     * @param null|int $newFileMode | 文件权限
     */
    public static function cpFile(string $src, string $dst, $newFileMode = null)
    {
        @copy($src, $dst);
        if (null !== $newFileMode) {
            @chmod($dst, $newFileMode);
        }
    }

    /**
     * 删除文件
     *
     * @param string $file
     * @return bool
     */
    public static function unlink(string $file): bool
    {
        if (file_exists($file)) {
            return @unlink($file);
        }
        return true;
    }

    /**
     * 获取文件中的内容
     *
     * @param string $file
     *
     * @return string|null
     */
    public static function getContent(string $file)
    {
        if (is_file($file)) {
            return file_get_contents($file);
        }
        return null;
    }

    /**
     * 将字符串写入文件中
     *      LOCK_EX : 文件锁定，只能同时一个人写
     *      FILE_APPEND : 文件追加
     *
     * @param string $file
     * @param string $content
     * @param bool $append
     * @return bool|int
     */
    public static function putContent(string $file, $content, $append = true)
    {
        if ($append) {
            return file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
        }
        return file_put_contents($file, $content, LOCK_EX);
    }

    /**
     * 创建文件夹
     *
     * @param string $dst
     * @param int $mode
     * @param bool $recursive
     * @return bool
     *
     * @throws Exception
     */
    public static function mkdir(string $dst, $mode = 0777, $recursive = false): bool
    {
        $prevDir = dirname($dst);
        if ($recursive && !is_dir($dst) && !is_dir($prevDir)) {
            self::mkdir(dirname($dst), $mode, true);
        }
        $res = @mkdir($dst, $mode);
        if (true === $res) {
            @chmod($dst, $mode);
        } else {
            throw new Exception('创建目录失败', 1010002001);
        }
        return $res;
    }

    /**
     * 删除文件夹
     *
     * @param string $dir
     * @param bool $recursive
     * @return bool
     */
    public static function rmdir(string $dir, $recursive = false): bool
    {
        $dir = realpath($dir);
        if (!is_dir($dir)) return true;
        if (true !== $recursive) return @rmdir($dir);
        $dp = @opendir($dir);
        while ($file = @readdir($dp)) {
            if ('.' === $file || '..' === $file) continue;
            $cur_file = $dir . '/' . $file;
            if (is_dir($cur_file)) {
                self::rmdir($cur_file, true);
            } elseif (is_file($cur_file)) {
                @unlink($cur_file);
            }
        }
        @closedir($dp);
        return @rmdir($dir);
    }

    /**
     * 复制目录
     *
     * @param string $src 拷贝源
     * @param string $dst 拷贝目标
     * @param array $options 拷贝选项
     *      array $fileTypes 需要拷贝的文件后缀列表，如果设置，将只拷贝这些后缀的文件
     *      array $exclude 忽略拷贝的文件或目录
     *          ".svn" : 将忽略所有名为".svn" 的目录和文件
     *          "/a/b" : 将忽略名为"$src/a/b" 的目录或文件
     *      int newDirMode 拷贝到新目录的目录权限，默认 "0777"
     *      int newFileMode 拷贝新文件的文件权限，默认 为当前系统的用户权限
     *
     * @throws Exception
     */
    public static function cpDir(string $src, string $dst, array $options = [])
    {
        $fileTypes = [];
        $exclude   = [];
        extract($options);
        if (!is_dir($dst)) {
            self::mkdir($dst, isset($options['newDirMode']) ? $options['newDirMode'] : 0777, true);
        }

        self::cpDirRecursive($src, $dst, '', $fileTypes, $exclude, $options);
    }

    /**
     * 递归复制目录
     *
     * @param string $src 拷贝源
     * @param string $dst 拷贝目标
     * @param string $base 拷贝当前目录
     * @param array $fileTypes 需要拷贝的文件后缀列表，如果设置，将只拷贝这些后缀的文件
     * @param array $exclude 忽略拷贝的文件或目录
     *      ".svn" : 将忽略所有名为".svn" 的目录和文件
     *      "/a/b" : 将忽略名为"$src/a/b" 的目录或文件
     * @param array $options
     *
     * @throws Exception
     */
    protected static function cpDirRecursive($src, $dst, $base, $fileTypes, $exclude, $options)
    {
        if (!is_dir($dst)) {
            self::mkdir($dst, isset($options['newDirMode']) ? $options['newDirMode'] : 0777, false);
        }

        $folder = @opendir($src);
        if ($folder === false) {
            throw new Exception(replace('不能打开目录"{path}"', [
                'path' => $src,
            ]), 1010002002);
        }
        while (($file = readdir($folder)) !== false) {
            if ('.' === $file || '..' === $file) {
                continue;
            }
            $path   = $src . DIRECTORY_SEPARATOR . $file;
            $isFile = is_file($path);
            if (self::validatePath($base, $file, $isFile, $fileTypes, $exclude)) {
                if ($isFile) {
                    copy($path, $dst . DIRECTORY_SEPARATOR . $file);
                    if (isset($options['newFileMode'])) {
                        @chmod($dst . DIRECTORY_SEPARATOR . $file, $options['newFileMode']);
                    }
                } else {
                    self::cpDirRecursive($path, $dst . DIRECTORY_SEPARATOR . $file, $base . '/' . $file, $fileTypes, $exclude, $options);
                }
            }
        }
        closedir($folder);
    }

    /**
     * 检验是否为合格有效的拷贝目录
     *
     * @param string $base 和源目录的相对目录
     * @param string $file 当前文件名
     * @param boolean $isFile 是否文件
     * @param array $fileTypes 需要的文件后缀列表
     * @param array $exclude 忽略的文件或目录
     * @return bool
     */
    protected static function validatePath($base, $file, $isFile, $fileTypes, $exclude): bool
    {
        foreach ($exclude as $e) {
            if ($file === $e || 0 === strpos($base . '/' . $file, $e)) {
                // 被忽略copy的文件或目录
                return false;
            }
        }
        if (!$isFile || empty($fileTypes)) {
            return true;
        }
        if ('' !== ($type = pathinfo($file, PATHINFO_EXTENSION))) {
            return in_array($type, $fileTypes);
        }
        return false;
    }
}