<?php
require_once 'oleread.inc';
define('SPREADSHEET_EXCEL_READER_BIFF8', 0x600);
define('SPREADSHEET_EXCEL_READER_BIFF7', 0x500);
define('SPREADSHEET_EXCEL_READER_WORKBOOKGLOBALS', 0x5);
define('SPREADSHEET_EXCEL_READER_WORKSHEET', 0x10);
define('SPREADSHEET_EXCEL_READER_TYPE_BOF', 0x809);
define('SPREADSHEET_EXCEL_READER_TYPE_EOF', 0x0a);
define('SPREADSHEET_EXCEL_READER_TYPE_BOUNDSHEET', 0x85);
define('SPREADSHEET_EXCEL_READER_TYPE_DIMENSION', 0x200);
define('SPREADSHEET_EXCEL_READER_TYPE_ROW', 0x208);
define('SPREADSHEET_EXCEL_READER_TYPE_DBCELL', 0xd7);
define('SPREADSHEET_EXCEL_READER_TYPE_FILEPASS', 0x2f);
define('SPREADSHEET_EXCEL_READER_TYPE_NOTE', 0x1c);
define('SPREADSHEET_EXCEL_READER_TYPE_TXO', 0x1b6);
define('SPREADSHEET_EXCEL_READER_TYPE_RK', 0x7e);
define('SPREADSHEET_EXCEL_READER_TYPE_RK2', 0x27e);
define('SPREADSHEET_EXCEL_READER_TYPE_MULRK', 0xbd);
define('SPREADSHEET_EXCEL_READER_TYPE_MULBLANK', 0xbe);
define('SPREADSHEET_EXCEL_READER_TYPE_INDEX', 0x20b);
define('SPREADSHEET_EXCEL_READER_TYPE_SST', 0xfc);
define('SPREADSHEET_EXCEL_READER_TYPE_EXTSST', 0xff);
define('SPREADSHEET_EXCEL_READER_TYPE_CONTINUE', 0x3c);
define('SPREADSHEET_EXCEL_READER_TYPE_LABEL', 0x204);
define('SPREADSHEET_EXCEL_READER_TYPE_LABELSST', 0xfd);
define('SPREADSHEET_EXCEL_READER_TYPE_NUMBER', 0x203);
define('SPREADSHEET_EXCEL_READER_TYPE_NAME', 0x18);
define('SPREADSHEET_EXCEL_READER_TYPE_ARRAY', 0x221);
define('SPREADSHEET_EXCEL_READER_TYPE_STRING', 0x207);
define('SPREADSHEET_EXCEL_READER_TYPE_FORMULA', 0x406);
define('SPREADSHEET_EXCEL_READER_TYPE_FORMULA2', 0x6);
define('SPREADSHEET_EXCEL_READER_TYPE_FORMAT', 0x41e);
define('SPREADSHEET_EXCEL_READER_TYPE_XF', 0xe0);
define('SPREADSHEET_EXCEL_READER_TYPE_BOOLERR', 0x205);
define('SPREADSHEET_EXCEL_READER_TYPE_UNKNOWN', 0xffff);
define('SPREADSHEET_EXCEL_READER_TYPE_NINETEENFOUR', 0x22);
define('SPREADSHEET_EXCEL_READER_TYPE_MERGEDCELLS', 0xE5);
define('SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS', 25569);
define('SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS1904', 24107);
define('SPREADSHEET_EXCEL_READER_MSINADAY', 86400);
define('SPREADSHEET_EXCEL_READER_DEF_NUM_FORMAT', '%s');
class Spreadsheet_Excel_Reader
{
    var $boundsheets = array();
    var $formatRecords = array();
    var $sst = array();
    var $sheets = array();
    var $data;
    var $_ole;
    var $_defaultEncoding;
    var $_defaultFormat = SPREADSHEET_EXCEL_READER_DEF_NUM_FORMAT;
    var $_columnsFormat = array();
    var $_rowoffset = 1;
    var $_coloffset = 1;
    var $dateFormats = array(0xe => "d/m/Y", 0xf => "d-M-Y", 0x10 => "d-M", 0x11 => "M-Y", 0x12 => "h:i a", 0x13 => "h:i:s a", 0x14 => "H:i", 0x15 => "H:i:s", 0x16 => "d/m/Y H:i", 0x2d => "i:s", 0x2e => "H:i:s", 0x2f => "i:s.S");
    var $numberFormats = array(0x1 => "%1.0f", 0x2 => "%1.2f", 0x3 => "%1.0f", 0x4 => "%1.2f", 0x5 => "%1.0f", 0x6 => '$%1.0f', 0x7 => '$%1.2f', 0x8 => '$%1.2f', 0x9 => '%1.0f%%', 0xa => '%1.2f%%', 0xb => '%1.2f', 0x25 => '%1.0f', 0x26 => '%1.0f', 0x27 => '%1.2f', 0x28 => '%1.2f', 0x29 => '%1.0f', 0x2a => '$%1.0f', 0x2b => '%1.2f', 0x2c => '$%1.2f', 0x30 => '%1.0f');
    function Spreadsheet_Excel_Reader()
    {
        $this->_ole =& new OLERead();
        $this->setUTFEncoder('iconv');
    }
    function setOutputEncoding($encoding)
    {
        $this->_defaultEncoding = $encoding;
    }
    function setUTFEncoder($encoder = 'iconv')
    {
        $this->_encoderFunction = '';
        if ($encoder == 'iconv') {
            $this->_encoderFunction = function_exists('iconv') ? 'iconv' : '';
        } elseif ($encoder == 'mb') {
            $this->_encoderFunction = function_exists('mb_convert_encoding') ? 'mb_convert_encoding' : '';
        }
    }
    function setRowColOffset($iOffset)
    {
        $this->_rowoffset = $iOffset;
        $this->_coloffset = $iOffset;
    }
    function setDefaultFormat($sFormat)
    {
        $this->_defaultFormat = $sFormat;
    }
    function setColumnFormat($column, $sFormat)
    {
        $this->_columnsFormat[$column] = $sFormat;
    }
    function read($sFileName)
    {
        $res = $this->_ole->read($sFileName);
        if ($res === false) {
            if ($this->_ole->error == 1) {
                die('The filename ' . $sFileName . ' is not readable');
            }
        }
        $this->data = $this->_ole->getWorkBook();
        $this->_parse();
    }
    function _parse()
    {
        $pos           = 0;
        $code          = ord($this->data[$pos]) | ord($this->data[$pos + 1]) << 8;
        $length        = ord($this->data[$pos + 2]) | ord($this->data[$pos + 3]) << 8;
        $version       = ord($this->data[$pos + 4]) | ord($this->data[$pos + 5]) << 8;
        $substreamType = ord($this->data[$pos + 6]) | ord($this->data[$pos + 7]) << 8;
        if (($version != SPREADSHEET_EXCEL_READER_BIFF8) && ($version != SPREADSHEET_EXCEL_READER_BIFF7)) {
            return false;
        }
        if ($substreamType != SPREADSHEET_EXCEL_READER_WORKBOOKGLOBALS) {
            return false;
        }
        $pos += $length + 4;
        $code   = ord($this->data[$pos]) | ord($this->data[$pos + 1]) << 8;
        $length = ord($this->data[$pos + 2]) | ord($this->data[$pos + 3]) << 8;
        while ($code != SPREADSHEET_EXCEL_READER_TYPE_EOF) {
            switch ($code) {
                case SPREADSHEET_EXCEL_READER_TYPE_SST:
                    $spos          = $pos + 4;
                    $limitpos      = $spos + $length;
                    $uniqueStrings = $this->_GetInt4d($this->data, $spos + 4);
                    $spos += 8;
                    for ($i = 0; $i < $uniqueStrings; $i++) {
                        if ($spos == $limitpos) {
                            $opcode    = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                            $conlength = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                            if ($opcode != 0x3c) {
                                return -1;
                            }
                            $spos += 4;
                            $limitpos = $spos + $conlength;
                        }
                        $numChars = ord($this->data[$spos]) | (ord($this->data[$spos + 1]) << 8);
                        $spos += 2;
                        $optionFlags = ord($this->data[$spos]);
                        $spos++;
                        $asciiEncoding  = (($optionFlags & 0x01) == 0);
                        $extendedString = (($optionFlags & 0x04) != 0);
                        $richString     = (($optionFlags & 0x08) != 0);
                        if ($richString) {
                            $formattingRuns = ord($this->data[$spos]) | (ord($this->data[$spos + 1]) << 8);
                            $spos += 2;
                        }
                        if ($extendedString) {
                            $extendedRunLength = $this->_GetInt4d($this->data, $spos);
                            $spos += 4;
                        }
                        $len = ($asciiEncoding) ? $numChars : $numChars * 2;
                        if ($spos + $len < $limitpos) {
                            $retstr = substr($this->data, $spos, $len);
                            $spos += $len;
                        } else {
                            $retstr    = substr($this->data, $spos, $limitpos - $spos);
                            $bytesRead = $limitpos - $spos;
                            $charsLeft = $numChars - (($asciiEncoding) ? $bytesRead : ($bytesRead / 2));
                            $spos      = $limitpos;
                            while ($charsLeft > 0) {
                                $opcode    = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                                $conlength = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                                if ($opcode != 0x3c) {
                                    return -1;
                                }
                                $spos += 4;
                                $limitpos = $spos + $conlength;
                                $option   = ord($this->data[$spos]);
                                $spos += 1;
                                if ($asciiEncoding && ($option == 0)) {
                                    $len = min($charsLeft, $limitpos - $spos);
                                    $retstr .= substr($this->data, $spos, $len);
                                    $charsLeft -= $len;
                                    $asciiEncoding = true;
                                } elseif (!$asciiEncoding && ($option != 0)) {
                                    $len = min($charsLeft * 2, $limitpos - $spos);
                                    $retstr .= substr($this->data, $spos, $len);
                                    $charsLeft -= $len / 2;
                                    $asciiEncoding = false;
                                } elseif (!$asciiEncoding && ($option == 0)) {
                                    $len = min($charsLeft, $limitpos - $spos);
                                    for ($j = 0; $j < $len; $j++) {
                                        $retstr .= $this->data[$spos + $j] . chr(0);
                                    }
                                    $charsLeft -= $len;
                                    $asciiEncoding = false;
                                } else {
                                    $newstr = '';
                                    for ($j = 0; $j < strlen($retstr); $j++) {
                                        $newstr = $retstr[$j] . chr(0);
                                    }
                                    $retstr = $newstr;
                                    $len    = min($charsLeft * 2, $limitpos - $spos);
                                    $retstr .= substr($this->data, $spos, $len);
                                    $charsLeft -= $len / 2;
                                    $asciiEncoding = false;
                                }
                                $spos += $len;
                            }
                        }
                        $retstr = ($asciiEncoding) ? $retstr : $this->_encodeUTF16($retstr);
                        if ($richString) {
                            $spos += 4 * $formattingRuns;
                        }
                        if ($extendedString) {
                            $spos += $extendedRunLength;
                        }
                        $this->sst[] = $retstr;
                    }
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_FILEPASS:
                    return false;
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_NAME:
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_FORMAT:
                    $indexCode = ord($this->data[$pos + 4]) | ord($this->data[$pos + 5]) << 8;
                    if ($version == SPREADSHEET_EXCEL_READER_BIFF8) {
                        $numchars = ord($this->data[$pos + 6]) | ord($this->data[$pos + 7]) << 8;
                        if (ord($this->data[$pos + 8]) == 0) {
                            $formatString = substr($this->data, $pos + 9, $numchars);
                        } else {
                            $formatString = substr($this->data, $pos + 9, $numchars * 2);
                        }
                    } else {
                        $numchars     = ord($this->data[$pos + 6]);
                        $formatString = substr($this->data, $pos + 7, $numchars * 2);
                    }
                    $this->formatRecords[$indexCode] = $formatString;
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_XF:
                    $indexCode = ord($this->data[$pos + 6]) | ord($this->data[$pos + 7]) << 8;
                    if (array_key_exists($indexCode, $this->dateFormats)) {
                        $this->formatRecords['xfrecords'][] = array(
                            'type' => 'date',
                            'format' => $this->dateFormats[$indexCode]
                        );
                    } elseif (array_key_exists($indexCode, $this->numberFormats)) {
                        $this->formatRecords['xfrecords'][] = array(
                            'type' => 'number',
                            'format' => $this->numberFormats[$indexCode]
                        );
                    } else {
                        $isdate = FALSE;
                        if ($indexCode > 0) {
                            if (isset($this->formatRecords[$indexCode]))
                                $formatstr = $this->formatRecords[$indexCode];
                            if ($formatstr)
                                if (preg_match("/[^hmsday\/\-:\s]/i", $formatstr) == 0) {
                                    $isdate    = TRUE;
                                    $formatstr = str_replace('mm', 'i', $formatstr);
                                    $formatstr = str_replace('h', 'H', $formatstr);
                                }
                        }
                        if ($isdate) {
                            $this->formatRecords['xfrecords'][] = array(
                                'type' => 'date',
                                'format' => $formatstr
                            );
                        } else {
                            $this->formatRecords['xfrecords'][] = array(
                                'type' => 'other',
                                'format' => '',
                                'code' => $indexCode
                            );
                        }
                    }
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_NINETEENFOUR:
                    $this->nineteenFour = (ord($this->data[$pos + 4]) == 1);
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_BOUNDSHEET:
                    $rec_offset         = $this->_GetInt4d($this->data, $pos + 4);
                    $rec_typeFlag       = ord($this->data[$pos + 8]);
                    $rec_visibilityFlag = ord($this->data[$pos + 9]);
                    $rec_length         = ord($this->data[$pos + 10]);
                    if ($version == SPREADSHEET_EXCEL_READER_BIFF8) {
                        $chartype = ord($this->data[$pos + 11]);
                        if ($chartype == 0) {
                            $rec_name = substr($this->data, $pos + 12, $rec_length);
                        } else {
                            $rec_name = $this->_encodeUTF16(substr($this->data, $pos + 12, $rec_length * 2));
                        }
                    } elseif ($version == SPREADSHEET_EXCEL_READER_BIFF7) {
                        $rec_name = substr($this->data, $pos + 11, $rec_length);
                    }
                    $this->boundsheets[] = array(
                        'name' => $rec_name,
                        'offset' => $rec_offset
                    );
                    break;
            }
            $pos += $length + 4;
            $code   = ord($this->data[$pos]) | ord($this->data[$pos + 1]) << 8;
            $length = ord($this->data[$pos + 2]) | ord($this->data[$pos + 3]) << 8;
        }
        foreach ($this->boundsheets as $key => $val) {
            $this->sn = $key;
            $this->_parsesheet($val['offset']);
        }
        return true;
    }
    function _parsesheet($spos)
    {
        $cont          = true;
        $code          = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
        $length        = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
        $version       = ord($this->data[$spos + 4]) | ord($this->data[$spos + 5]) << 8;
        $substreamType = ord($this->data[$spos + 6]) | ord($this->data[$spos + 7]) << 8;
        if (($version != SPREADSHEET_EXCEL_READER_BIFF8) && ($version != SPREADSHEET_EXCEL_READER_BIFF7)) {
            return -1;
        }
        if ($substreamType != SPREADSHEET_EXCEL_READER_WORKSHEET) {
            return -2;
        }
        $spos += $length + 4;
        while ($cont) {
            $lowcode = ord($this->data[$spos]);
            if ($lowcode == SPREADSHEET_EXCEL_READER_TYPE_EOF)
                break;
            $code   = $lowcode | ord($this->data[$spos + 1]) << 8;
            $length = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
            $spos += 4;
            $this->sheets[$this->sn]['maxrow'] = $this->_rowoffset - 1;
            $this->sheets[$this->sn]['maxcol'] = $this->_coloffset - 1;
            unset($this->rectype);
            $this->multiplier = 1;
            switch ($code) {
                case SPREADSHEET_EXCEL_READER_TYPE_DIMENSION:
                    if (!isset($this->numRows)) {
                        if (($length == 10) || ($version == SPREADSHEET_EXCEL_READER_BIFF7)) {
                            $this->sheets[$this->sn]['numRows'] = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                            $this->sheets[$this->sn]['numCols'] = ord($this->data[$spos + 6]) | ord($this->data[$spos + 7]) << 8;
                        } else {
                            $this->sheets[$this->sn]['numRows'] = ord($this->data[$spos + 4]) | ord($this->data[$spos + 5]) << 8;
                            $this->sheets[$this->sn]['numCols'] = ord($this->data[$spos + 10]) | ord($this->data[$spos + 11]) << 8;
                        }
                    }
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_MERGEDCELLS:
                    $cellRanges = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    for ($i = 0; $i < $cellRanges; $i++) {
                        $fr = ord($this->data[$spos + 8 * $i + 2]) | ord($this->data[$spos + 8 * $i + 3]) << 8;
                        $lr = ord($this->data[$spos + 8 * $i + 4]) | ord($this->data[$spos + 8 * $i + 5]) << 8;
                        $fc = ord($this->data[$spos + 8 * $i + 6]) | ord($this->data[$spos + 8 * $i + 7]) << 8;
                        $lc = ord($this->data[$spos + 8 * $i + 8]) | ord($this->data[$spos + 8 * $i + 9]) << 8;
                        if ($lr - $fr > 0) {
                            $this->sheets[$this->sn]['cellsInfo'][$fr + 1][$fc + 1]['rowspan'] = $lr - $fr + 1;
                        }
                        if ($lc - $fc > 0) {
                            $this->sheets[$this->sn]['cellsInfo'][$fr + 1][$fc + 1]['colspan'] = $lc - $fc + 1;
                        }
                    }
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_RK:
                case SPREADSHEET_EXCEL_READER_TYPE_RK2:
                    $row      = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    $column   = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                    $rknum    = $this->_GetInt4d($this->data, $spos + 6);
                    $numValue = $this->_GetIEEE754($rknum);
                    if ($this->isDate($spos)) {
                        list($string, $raw) = $this->createDate($numValue);
                    } else {
                        $raw = $numValue;
                        if (isset($this->_columnsFormat[$column + 1])) {
                            $this->curformat = $this->_columnsFormat[$column + 1];
                        }
                        $string = sprintf($this->curformat, $numValue * $this->multiplier);
                    }
                    $this->addcell($row, $column, $string, $raw);
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_LABELSST:
                    $row     = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    $column  = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                    $xfindex = ord($this->data[$spos + 4]) | ord($this->data[$spos + 5]) << 8;
                    $index   = $this->_GetInt4d($this->data, $spos + 6);
                    $this->addcell($row, $column, $this->sst[$index]);
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_MULRK:
                    $row      = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    $colFirst = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                    $colLast  = ord($this->data[$spos + $length - 2]) | ord($this->data[$spos + $length - 1]) << 8;
                    $columns  = $colLast - $colFirst + 1;
                    $tmppos   = $spos + 4;
                    for ($i = 0; $i < $columns; $i++) {
                        $numValue = $this->_GetIEEE754($this->_GetInt4d($this->data, $tmppos + 2));
                        if ($this->isDate($tmppos - 4)) {
                            list($string, $raw) = $this->createDate($numValue);
                        } else {
                            $raw = $numValue;
                            if (isset($this->_columnsFormat[$colFirst + $i + 1])) {
                                $this->curformat = $this->_columnsFormat[$colFirst + $i + 1];
                            }
                            $string = sprintf($this->curformat, $numValue * $this->multiplier);
                        }
                        $tmppos += 6;
                        $this->addcell($row, $colFirst + $i, $string, $raw);
                    }
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_NUMBER:
                    $row    = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    $column = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                    $tmp    = unpack("ddouble", substr($this->data, $spos + 6, 8));
                    if ($this->isDate($spos)) {
                        list($string, $raw) = $this->createDate($tmp['double']);
                    } else {
                        if (isset($this->_columnsFormat[$column + 1])) {
                            $this->curformat = $this->_columnsFormat[$column + 1];
                        }
                        $raw    = $this->createNumber($spos);
                        $string = sprintf($this->curformat, $raw * $this->multiplier);
                    }
                    $this->addcell($row, $column, $string, $raw);
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_FORMULA:
                case SPREADSHEET_EXCEL_READER_TYPE_FORMULA2:
                    $row    = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    $column = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                    if ((ord($this->data[$spos + 6]) == 0) && (ord($this->data[$spos + 12]) == 255) && (ord($this->data[$spos + 13]) == 255)) {
                    } elseif ((ord($this->data[$spos + 6]) == 1) && (ord($this->data[$spos + 12]) == 255) && (ord($this->data[$spos + 13]) == 255)) {
                    } elseif ((ord($this->data[$spos + 6]) == 2) && (ord($this->data[$spos + 12]) == 255) && (ord($this->data[$spos + 13]) == 255)) {
                    } elseif ((ord($this->data[$spos + 6]) == 3) && (ord($this->data[$spos + 12]) == 255) && (ord($this->data[$spos + 13]) == 255)) {
                    } else {
                        $tmp = unpack("ddouble", substr($this->data, $spos + 6, 8));
                        if ($this->isDate($spos)) {
                            list($string, $raw) = $this->createDate($tmp['double']);
                        } else {
                            if (isset($this->_columnsFormat[$column + 1])) {
                                $this->curformat = $this->_columnsFormat[$column + 1];
                            }
                            $raw    = $this->createNumber($spos);
                            $string = sprintf($this->curformat, $raw * $this->multiplier);
                        }
                        $this->addcell($row, $column, $string, $raw);
                    }
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_BOOLERR:
                    $row    = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    $column = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                    $string = ord($this->data[$spos + 6]);
                    $this->addcell($row, $column, $string);
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_ROW:
                case SPREADSHEET_EXCEL_READER_TYPE_DBCELL:
                case SPREADSHEET_EXCEL_READER_TYPE_MULBLANK:
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_LABEL:
                    $row    = ord($this->data[$spos]) | ord($this->data[$spos + 1]) << 8;
                    $column = ord($this->data[$spos + 2]) | ord($this->data[$spos + 3]) << 8;
                    $this->addcell($row, $column, substr($this->data, $spos + 8, ord($this->data[$spos + 6]) | ord($this->data[$spos + 7]) << 8));
                    break;
                case SPREADSHEET_EXCEL_READER_TYPE_EOF:
                    $cont = false;
                    break;
                default:
                    break;
            }
            $spos += $length;
        }
        if (!isset($this->sheets[$this->sn]['numRows']))
            $this->sheets[$this->sn]['numRows'] = $this->sheets[$this->sn]['maxrow'];
        if (!isset($this->sheets[$this->sn]['numCols']))
            $this->sheets[$this->sn]['numCols'] = $this->sheets[$this->sn]['maxcol'];
    }
    function isDate($spos)
    {
        $xfindex = ord($this->data[$spos + 4]) | ord($this->data[$spos + 5]) << 8;
        if ($this->formatRecords['xfrecords'][$xfindex]['type'] == 'date') {
            $this->curformat = $this->formatRecords['xfrecords'][$xfindex]['format'];
            $this->rectype   = 'date';
            return true;
        } else {
            if ($this->formatRecords['xfrecords'][$xfindex]['type'] == 'number') {
                $this->curformat = $this->formatRecords['xfrecords'][$xfindex]['format'];
                $this->rectype   = 'number';
                if (($xfindex == 0x9) || ($xfindex == 0xa)) {
                    $this->multiplier = 100;
                }
            } else {
                $this->curformat = $this->_defaultFormat;
                $this->rectype   = 'unknown';
            }
            return false;
        }
    }
    function createDate($numValue)
    {
        if ($numValue > 1) {
            $utcDays  = $numValue - ($this->nineteenFour ? SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS1904 : SPREADSHEET_EXCEL_READER_UTCOFFSETDAYS);
            $utcValue = round(($utcDays + 1) * SPREADSHEET_EXCEL_READER_MSINADAY);
            $string   = date($this->curformat, $utcValue);
            $raw      = $utcValue;
        } else {
            $raw    = $numValue;
            $hours  = floor($numValue * 24);
            $mins   = floor($numValue * 24 * 60) - $hours * 60;
            $secs   = floor($numValue * SPREADSHEET_EXCEL_READER_MSINADAY) - $hours * 60 * 60 - $mins * 60;
            $string = date($this->curformat, mktime($hours, $mins, $secs));
        }
        return array(
            $string,
            $raw
        );
    }
    function createNumber($spos)
    {
        $rknumhigh    = $this->_GetInt4d($this->data, $spos + 10);
        $rknumlow     = $this->_GetInt4d($this->data, $spos + 6);
        $sign         = ($rknumhigh & 0x80000000) >> 31;
        $exp          = ($rknumhigh & 0x7ff00000) >> 20;
        $mantissa     = (0x100000 | ($rknumhigh & 0x000fffff));
        $mantissalow1 = ($rknumlow & 0x80000000) >> 31;
        $mantissalow2 = ($rknumlow & 0x7fffffff);
        $value        = $mantissa / pow(2, (20 - ($exp - 1023)));
        if ($mantissalow1 != 0)
            $value += 1 / pow(2, (21 - ($exp - 1023)));
        $value += $mantissalow2 / pow(2, (52 - ($exp - 1023)));
        if ($sign) {
            $value = -1 * $value;
        }
        return $value;
    }
    function addcell($row, $col, $string, $raw = '')
    {
        $this->sheets[$this->sn]['maxrow']                                                    = max($this->sheets[$this->sn]['maxrow'], $row + $this->_rowoffset);
        $this->sheets[$this->sn]['maxcol']                                                    = max($this->sheets[$this->sn]['maxcol'], $col + $this->_coloffset);
        $this->sheets[$this->sn]['cells'][$row + $this->_rowoffset][$col + $this->_coloffset] = $string;
        if ($raw)
            $this->sheets[$this->sn]['cellsInfo'][$row + $this->_rowoffset][$col + $this->_coloffset]['raw'] = $raw;
        if (isset($this->rectype))
            $this->sheets[$this->sn]['cellsInfo'][$row + $this->_rowoffset][$col + $this->_coloffset]['type'] = $this->rectype;
    }
    function _GetIEEE754($rknum)
    {
        if (($rknum & 0x02) != 0) {
            $value = $rknum >> 2;
        } else {
            $sign     = ($rknum & 0x80000000) >> 31;
            $exp      = ($rknum & 0x7ff00000) >> 20;
            $mantissa = (0x100000 | ($rknum & 0x000ffffc));
            $value    = $mantissa / pow(2, (20 - ($exp - 1023)));
            if ($sign) {
                $value = -1 * $value;
            }
        }
        if (($rknum & 0x01) != 0) {
            $value /= 100;
        }
        return $value;
    }
    function _encodeUTF16($string)
    {
        $result = $string;
        if ($this->_defaultEncoding) {
            switch ($this->_encoderFunction) {
                case 'iconv':
                    $result = iconv('UTF-16LE', $this->_defaultEncoding, $string);
                    break;
                case 'mb_convert_encoding':
                    $result = mb_convert_encoding($string, $this->_defaultEncoding, 'UTF-16LE');
                    break;
            }
        }
        return $result;
    }
    function _GetInt4d($data, $pos)
    {
        $value = ord($data[$pos]) | (ord($data[$pos + 1]) << 8) | (ord($data[$pos + 2]) << 16) | (ord($data[$pos + 3]) << 24);
        if ($value >= 4294967294) {
            $value = -2;
        }
        return $value;
    }
}
