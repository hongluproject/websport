<?php
/**
 * XML
 *
 * Converts any variable type (arrays, objects, strings) to a SimpleXML object.
 *
 * @package        MicroMVC
 * @author         David Pennington
 * @copyright      (c) 2011 MicroMVC Framework
 * @license        http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */
namespace Core;

class XML
{
    public static function toArray($content)
    {
        $dom = new \DOMDocument();
        $dom->loadXML($content);
        return self::_structArray($dom);
    }

    public static function _structArray(\DOMNode $node)
    {
        $occurance = array();
        $result = array();


        if ($node->childNodes)
        {
            foreach ($node->childNodes as $child)
            {
                $occurance[$child->nodeName]++;
            }
        }

        if ($node->nodeType == XML_TEXT_NODE)
        {
            $result = html_entity_decode(htmlentities($node->nodeValue, ENT_COMPAT, 'UTF-8'), ENT_COMPAT, 'ISO-8859-15');
        }
        else
        {
            if ($node->hasChildNodes())
            {
                $children = $node->childNodes;

                for ($i = 0; $i < $children->length; $i++)
                {
                    $child = $children->item($i);

                    if ($child->nodeName != '#text')
                    {
                        if ($occurance[$child->nodeName] > 1)
                        {
                            $result[$child->nodeName][] = self::_structArray($child);
                        }
                        else
                        {
                            $result[$child->nodeName] = self::_structArray($child);
                        }
                    }
                    else {
                        if ($child->nodeName == '#text')
                        {
                            $text = self::_structArray($child);

                            if (trim($text) != '')
                            {
                                $result[$child->nodeName] = self::_structArray($child);
                            }
                        }
                    }
                }
            }

            if ($node->hasAttributes())
            {
                $attributes = $node->attributes;

                if (!is_null($attributes))
                {
                    foreach ($attributes as $key => $attr)
                    {
                        $result["@" . $attr->name] = $attr->value;
                    }
                }
            }
        }

        return $result;
    }

    public static function fromArray($object, $root = 'root', $unknown = 'item', $doctype = '<?xml version="1.0" encoding="utf-8""?>')
    {
        return $doctype . "<{$root}>" . self::_structXml($object, $unknown) . "</{$root}>";
    }

    private static function _structXml($array, $unknown = 'item')
    {
        $xml = '';
        foreach ($array as $k => $v)
        {
            $tag = $k;
            $attr = '';
            if (preg_match('/^[0-9]+/', $k))
            {
                $tag = $unknown;
                $attr = " key=\"{$k}\"";
            }
            if (is_array($v))
            {
                $xml .= "<$tag{$attr}>";
                $xml .= self::_structXml($v, $unknown);
                $xml .= "</$tag>";
            }
            else
            {
                if (!preg_match("/[" . chr(0xa1) . "-" . chr(0xff) . "]+/i", $v) && !preg_match("/[\xa1-\xff]+/i", $v) && !preg_match("/[&]/i", $v))
                {
                    $xml .= "<$tag{$attr}>$v</$tag>";
                }
                else
                {
                    $xml .= "<$tag{$attr}><![CDATA[$v]]></$tag>";
                }
            }
        }

        return $xml;
    }


}

// END