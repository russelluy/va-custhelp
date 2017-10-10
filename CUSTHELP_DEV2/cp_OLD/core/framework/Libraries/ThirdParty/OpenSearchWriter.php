<?php
namespace RightNow\Libraries\ThirdParty;
// ----------------------------------------------------------------------------
//       File Name: opensearch.phph
//       Subsystem: enduser
//   Document Type: opensearch header
// Req. Parameters: none
// Opt. Parameters: none
//  Included Files: none
//         Purpose: provides xml and RSS writer classes for opensearch
//                  output of enduser search results
// ----------------------------------------------------------------------------


// ----- Start of OpenSearch XML Generator -----------------------------------------------------------

    /*
      Copyright (c) 2001-2005, Manuel Lemos
      All rights reserved.

      Redistribution and use in source and binary forms, with or without
      modification, are permitted provided that the following conditions are
      met:

          * Redistributions of source code must retain the above copyright
            notice, this list of conditions and the following disclaimer.
          * Redistributions in binary form must reproduce the above copyright
            notice, this list of conditions and the following disclaimer in the
            documentation and/or other materials provided with the distribution.
          * Neither the name of the Manuel Lemos nor the names of its
            contributors may be used to endorse or promote products derived from
            this software without specific prior written permission.

      THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
      IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
      THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
      PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
      CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
      EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
      PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
      PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
      LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
      NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
      SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
    */

    /*
     *
     * Copyright © (C) Manuel Lemos 2001-2002
     *
     */

class xml_writer_class
{
    /*
     * Protected variables
     *
     */
    var $structure=array();
    var $nodes=array();

    /*
     * Public variables
     *
     */
    var $stylesheet="";
    var $stylesheettype="text/xsl";
    var $dtdtype="";
    var $dtddefinition="";
    var $dtdurl="";
    var $outputencoding="utf-8";
    var $inputencoding="utf-8";
    var $linebreak="\n";
    var $indenttext=" ";
    var $generatedcomment="Generated by: http://www.phpclasses.org/xmlwriter";
    var $error="";


    /*
     * Protected functions
     *
     */
    Function escapedata($data)
    {
        $position=0;
        $length=strlen($data);
        $escapeddata="";
        for(;$position<$length;)
        {
            $character=substr($data,$position,1);
            $code=Ord($character);
            switch($code)
            {
                case 34:
                    $character="&quot;";
                    break;
                case 38:
                    $character="&amp;";
                    break;
                case 39:
                    $character="&apos;";
                    break;
                case 60:
                    $character="&lt;";
                    break;
                case 62:
                    $character="&gt;";
                    break;
                default:
                    if($code<32)
                        $character=("&#".strval($code).";");
                    break;
            }
            $escapeddata.=$character;
            $position++;
        }
        return $escapeddata;
    }

    Function encodedata($data,&$encodeddata)
    {
        if(!strcmp($this->inputencoding,$this->outputencoding))
            $encodeddata=$this->escapedata($data);
        else
        {
            switch(strtolower($this->outputencoding))
            {
                case "utf-8":
                    if(!strcmp(strtolower($this->inputencoding),"iso-8859-1"))
                    {
                        $encoded_data=utf8_encode($this->escapedata($data));
                        $encodeddata=$encoded_data;
                    }
                    else
                    {
                        $this->error=("can not encode iso-8859-1 data in ".$this->outputencoding);
                        return 0;
                    }
                    break;
                case "iso-8859-1":
                    if(!strcmp(strtolower($this->inputencoding),"utf-8"))
                    {
                        $decoded=utf8_decode($data);
                        $encodeddata=$this->escapedata($decoded);
                    }
                    else
                    {
                        $this->error=("can not encode utf-8 data in ".$this->outputencoding);
                        return 0;
                    }
                    break;
                default:
                    $this->error=("can not encode data in ".$this->inputencoding);
                    return 0;
            }
        }
        return 1;
    }

    Function writetag(&$output,$path,$indent)
    {
        $tag=$this->structure[$path]["Tag"];
        $output.=("<".$tag);
        $attributecount=count($this->structure[$path]["Attributes"]);
        if($attributecount>0)
        {
            $attributes=$this->structure[$path]["Attributes"];
            Reset($attributes);
            $end=(GetType($key=Key($attributes))!="string");
            for(;!$end;)
            {
                $output.=(" ".$key."=\"".$attributes[$key]."\"");
                Next($attributes);
                $end=(GetType($key=Key($attributes))!="string");
            }
        }
        $elements=$this->structure[$path]["Elements"];
        if($elements>0)
        {
            $output.=">";
            $doindent=$this->structure[$path]["Indent"];
            $elementindent=(($doindent) ? $this->linebreak.$indent.$this->indenttext : "");
            $element=0;
            for(;$element<$elements;)
            {
                $elementpath=($path.",".strval($element));
                $output.=$elementindent;
                if(IsSet($this->nodes[$elementpath]))
                {
                    if(!($this->writetag($output,$elementpath,$indent.$this->indenttext)))
                        return 0;
                }
                else
                    $output.=$this->structure[$elementpath];
                $element++;
            }
            $output.=((($doindent) ? $this->linebreak.$indent : "")."</".$tag.">");
        }
        else
            $output.="/>";
        return 1;
    }

    /*
     * Public functions
     *
     */
    Function write(&$output)
    {
        if(strcmp($this->error,""))
            return 0;
        if(!(IsSet($this->structure["0"])))
        {
            $this->error="XML document structure is empty";
            return 0;
        }
        $output=("<?xml version=\"1.0\" encoding=\"".$this->outputencoding."\"?>".$this->linebreak);
        if(strcmp($this->dtdtype,""))
        {
            $output.=("<!DOCTYPE ".$this->structure["0"]["Tag"]." ");
            switch($this->dtdtype)
            {
                case "INTERNAL":
                    if(!strcmp($this->dtddefinition,""))
                    {
                        $this->error="it was not specified a valid internal DTD definition";
                        return 0;
                    }
                    $output.=("[".$this->linebreak.$this->dtddefinition.$this->linebreak."]");
                    break;
                case "SYSTEM":
                    if(!strcmp($this->dtdurl,""))
                    {
                        $this->error="it was not specified a valid system DTD url";
                        return 0;
                    }
                    $output.="SYSTEM";
                    if(strcmp($this->dtddefinition,""))
                        $output.=(" \"".$this->dtddefinition."\"");
                    $output.=(" \"".$this->dtdurl."\"");
                    break;
                case "PUBLIC":
                    if(!strcmp($this->dtddefinition,""))
                    {
                        $this->error="it was not specified a valid public DTD definition";
                        return 0;
                    }
                    $output.=("PUBLIC \"".$this->dtddefinition."\"");
                    if(strcmp($this->dtdurl,""))
                        $output.=(" \"".$this->dtdurl."\"");
                    break;
                default:
                    $this->error="it was not specified a valid DTD type";
                    return 0;
            }
            $output.=(">".$this->linebreak);
        }
        if(strcmp($this->stylesheet,""))
        {
            if(!strcmp($this->stylesheettype,""))
            {
                $this->error="it was not specified a valid stylesheet type";
                return 0;
            }
            $output.=("<?xml-stylesheet type=\"".$this->stylesheettype."\" href=\"".$this->stylesheet."\"?>".$this->linebreak);
        }
        if(strcmp($this->generatedcomment,""))
            $output.=("<!-- ".$this->generatedcomment." -->".$this->linebreak);
        return $this->writetag($output,"0","");
    }

    Function addtag($tag,&$attributes,$parent,&$path,$indent)
    {
        if(strcmp($this->error,""))
            return 0;
        $path=((!strcmp($parent,"")) ? "0" : ($parent.",".strval($this->structure[$parent]["Elements"])));
        if(IsSet($this->structure[$path]))
        {
            $this->error=("tag with path ".$path." is already defined");
            return 0;
        }
        $encodedattributes=array();
        Reset($attributes);
        $end=(GetType($attribute_name=Key($attributes))!="string");
        for(;!$end;)
        {
            $encodedattributes[$attribute_name]="";
            if(!($this->encodedata($attributes[$attribute_name],$encoded_data)))
                return 0;
            $encodedattributes[$attribute_name]=$encoded_data;
            Next($attributes);
            $end=(GetType($attribute_name=Key($attributes))!="string");
        }
        $this->structure[$path]=array(
            "Tag"=>$tag,
            "Attributes"=>$encodedattributes,
            "Elements"=>0,
            "Indent"=>$indent
        );
        $this->nodes[$path]=1;
        if(strcmp($parent,""))
            $this->structure[$parent]["Elements"]=($this->structure[$parent]["Elements"]+1);
        return 1;
    }

    Function adddata($data,$parent,&$path)
    {
        if(strcmp($this->error,""))
            return 0;
        if(!(IsSet($this->structure[$parent])))
        {
            $this->error=("the parent tag path".$path."is not defined");
            return 0;
        }
        if(!strcmp($data,""))
            return 1;
        $path=($parent.",".strval($this->structure[$parent]["Elements"]));
        if(!($this->encodedata($data,$encoded_data)))
            return 0;
        $this->structure[$path]=$encoded_data;
        $this->structure[$parent]["Elements"]=($this->structure[$parent]["Elements"]+1);
        return 1;
    }

    Function adddatatag($tag,&$attributes,$data,$parent,&$path)
    {
        return $this->addtag($tag,$attributes,$parent,$path,0) && $this->adddata($data,$path,$datapath);
    }
};

    /*
     *
     * Copyright © (C) Manuel Lemos 2002-2006
     *
     */

class rss_writer_class extends xml_writer_class
{
    /*
     * Protected variables
     *
     */
    var $root='';
    var $channel='';
    var $image='';
    var $textinput='';
    var $items=0;
    var $itemsequence='';

    /*
     * Public variables
     *
     */
    var $specification='1.0';
    var $about='';
    var $rssnamespaces=array();
    var $allownoitems=0;
    var $generatedcomment='Generated by: http://www.phpclasses.org/rsswriter';

    /*
     * Protected functions
     *
     */
    Function addrssproperties(&$properties,$parent,&$required,&$optional,&$multiple,$scope)
    {
        $noattributes=array();
        $required_properties=0;
        Reset($properties);
        $end=(GetType($property=Key($properties))!='string');
        for(;!$end;)
        {
            $using_namespaces=GetType($colon=strpos($property,':',0))=='integer';
            if($using_namespaces)
                $namespace=substr($property,0,$colon);
            if(IsSet($required[$property]))
            {
                if($required[$property])
                {
                    $this->error=('required '.$scope.' property "'.$property.'" is already set');
                    return 0;
                }
                $required[$property]=1;
                $required_properties++;
            }
            else
            {
                if(IsSet($optional[$property]))
                {
                    if($optional[$property])
                    {
                        $this->error=('optional '.$scope.' property "'.$property.'" is already set');
                        return 0;
                    }
                    $optional[$property]=1;
                }
                else
                {
                    if($using_namespaces)
                    {
                        if(!(!strcmp($namespace,'rdf') || IsSet($this->rssnamespaces[$namespace])))
                        {
                            $this->error=('the name space of property "'.$property.'" was not declared');
                            return 0;
                        }
                    }
                    else
                    {
                        $this->error=('"'.$property.'" is not a supported '.$scope.' property');
                        return 0;
                    }
                }
            }
            if(is_array($properties[$property]))
            {
                if(!$using_namespaces && count($properties[$property])>1 && !IsSet($multiple[$property]))
                {
                    $this->error=$scope.' property '.$property.' may not have multiple values';
                    return 0;
                }
                foreach ($properties[$property] as $prop)
                {
                    if (is_array($prop))
                    {

                        if(!($this->adddatatag($property,$prop['attributes'],$prop['value'],$parent,$path)))
                            return 0;
                    }
                    else
                    {
                        if(!($this->adddatatag($property,$noattributes,$prop,$parent,$path)))
                            return 0;
                    }
                }
            }
            else
            {
                if(!($this->adddatatag($property,$noattributes,$properties[$property],$parent,$path)))
                    return 0;
            }
            Next($properties);
            $end=(GetType($property=Key($properties))!='string');
        }
        if($required_properties<count($required))
        {
            Reset($required);
            $end=(GetType($property=Key($required))!='string');
            for(;!$end;)
            {
                if(!($required[$property]))
                {
                    $this->error=('it was not specified the required '.$scope.' property "'.$property.'"');
                    return 0;
                }
                Next($required);
                $end=(GetType($property=Key($required))!='string');
            }
        }
        return 1;
    }

    /*
     * Public functions
     *
     */
    Function addchannel(&$properties)
    {
        if(strcmp($this->error,''))
            return 0;
        if(strcmp($this->channel,''))
        {
            $this->error='a channel was already added';
            return 0;
        }
        $channel_attributes=array();
        $multiple=array();
        switch($this->specification)
        {
            case '0.9':
                $root='rdf:RDF';
                $attributes=array('xmlns:rdf'=>'http://www.w3.org/1999/02/22-rdf-syntax-ns#','xmlns'=>'http://my.netscape.com/rdf/simple/0.9/');
                $required=array('description'=>0,'link'=>0,'title'=>0);
                $optional=array();
                break;
            case '0.91':
                $root='rss';
                $attributes=array('version'=>$this->specification);
                $required=array('description'=>0,'language'=>0,'link'=>0,'title'=>0);
                $optional=array('copyright'=>0,'docs'=>0,'lastBuildDate'=>0,'managingEditor'=>0,'pubDate'=>0,'rating'=>0,'skipDays'=>0,'skipHours'=>0,'webMaster'=>0);
                break;
            case '1.0':
                if(!strcmp($this->about,''))
                {
                    $this->error='it was not specified the about URL attribute';
                    return 0;
                }
                $root='rdf:RDF';
                $attributes=array('xmlns:rdf'=>'http://www.w3.org/1999/02/22-rdf-syntax-ns#','xmlns'=>'http://purl.org/rss/1.0/');
                $channel_attributes=array('rdf:about'=>$this->about);
                $required=array('description'=>0,'link'=>0,'title'=>0);
                $optional=array();
                break;
            case '2.0':
                $root='rss';
                $attributes=array('version'=>$this->specification);
                $required=array('description'=>0,'link'=>0,'title'=>0);
                $optional=array('copyright'=>0,'docs'=>0,'generator'=>0,'language'=>0,'lastBuildDate'=>0,'managingEditor'=>0,'pubDate'=>0,'rating'=>0,'skipDays'=>0,'skipHours'=>0,'ttl'=>0,'webMaster'=>0);
                break;
            default:
                $this->error='it was not specified a supported RSS specification version';
                return 0;
        }
        Reset($this->rssnamespaces);
        $end=(GetType($namespace=Key($this->rssnamespaces))!='string');
        for(;!$end;)
        {
            if(!strcmp($namespace,'rdf'))
            {
                $this->error='the rdf namespace is being redeclared';
                return 0;
            }
            $attributes[('xmlns:'.$namespace)]=$this->rssnamespaces[$namespace];
            Next($this->rssnamespaces);
            $end=(GetType($namespace=Key($this->rssnamespaces))!='string');
        }
        $this->addtag($root,$attributes,'',$path,1);
        $this->root=$path;
        if(!($this->addtag('channel',$channel_attributes,$this->root,$path,1)))
            return 0;
        if(!($this->addrssproperties($properties,$path,$required,$optional,$multiple,'channel'))) return 0;
        $this->channel=$path;
        return 1;
    }

    Function addchanneltag($tag, $attributes, $data)
    {
        if(strcmp($this->error,''))
        {
            //echo "...[ERROR not adding this item]...";  //debug
            return 0;
        }
        if(!strcmp($this->channel,''))
        {
            $this->error='the channel was not yet added';
            return 0;
        }
        if($this->items!=0)
        {
            $this->error='channel tags can only be defined before adding the channel items';
            return 0;
        }
        switch($this->specification)
        {
            case '0.9':
                $parent=$this->root;
                break;
            case '0.91':
                $parent=$this->channel;
                break;
            case '1.0':
                $parent=$this->root;
                break;
            case '2.0':
                $parent=$this->channel;
                break;
            default:
                $this->error='it was not specified a supported RSS specification version';
                return 0;
        }
        if(!($this->adddatatag($tag,$attributes,$data,$parent,$path)))
            return 0;
        //echo "... addtag ok ...";  //debug
        return 1;
    }


    Function addrelated(&$properties)
    {
        if(strcmp($this->error,''))
        {
            //echo "...[ERROR not adding this item]...";  //debug
            return 0;
        }
        if(!strcmp($this->channel,''))
        {
            $this->error='the channel was not yet added';
            return 0;
        }
        if(strcmp($this->textinput,''))
        {
            $this->error='items can not be added to the channel after defining the textinput';
            return 0;
        }
        $attributes=array();
        $required=array('link'=>0,'title'=>0);
        $optional=array('description'=>0);
        $multiple=array();
        switch($this->specification)
        {
            case '0.9':
                $parent=$this->root;
                break;
            case '0.91':
                $parent=$this->channel;
                break;
            case '1.0':
                if(IsSet($properties['link']))
                    $attributes['rdf:about']=$properties['link'];
                $parent=$this->root;
                break;
            case '2.0':
                $parent=$this->channel;
                $required=array('link'=>0,'title'=>0);
                $optional=array('description'=>0,'author'=>0,'comments'=>0,'pubDate'=>0,'source'=>0,'category'=>0,'guid'=>0);
                $multiple=array('category'=>1);
                break;
            default:
                $this->error='it was not specified a supported RSS specification version';
                return 0;
        }
        if(!($this->addtag('related:topic',$attributes,$parent,$path,1)))
            return 0;
        //echo "... addtag ok ...";  //debug
        if(!($this->addrssproperties($properties,$path,$required,$optional,$multiple,'item')))
            return 0;
        //echo "... addrssprop ok ..."; //debug
        if(!strcmp($this->specification,'1.0'))
        {
            if(!strcmp($this->itemsequence,''))
            {
                $attributes=array();
                if(!($this->addtag('items',$attributes,$this->channel,$path,1) && $this->addtag('rdf:Seq',$attributes,$path,$path,1)))
                    return 0;
                $this->itemsequence=$path;
            }
            $attributes=array('rdf:resource'=>$properties['link']);
            if(!($this->addtag('rdf:li',$attributes,$this->itemsequence,$path,0)))
                return 0;
        }
        $this->items++;
        return 1;
    }


    Function additem(&$properties)
    {
        if(strcmp($this->error,''))
        {
            //echo "...[ERROR not adding this item]...";  //debug
            return 0;
        }
        if(!strcmp($this->channel,''))
        {
            $this->error='the channel was not yet added';
            return 0;
        }
        if(strcmp($this->textinput,''))
        {
            $this->error='items can not be added to the channel after defining the textinput';
            return 0;
        }
        $attributes=array();
        $required=array('link'=>0,'title'=>0);
        $optional=array('description'=>0);
        $multiple=array();
        switch($this->specification)
        {
            case '0.9':
                $parent=$this->root;
                break;
            case '0.91':
                $parent=$this->channel;
                break;
            case '1.0':
                if(IsSet($properties['link']))
                    $attributes['rdf:about']=$properties['link'];
                $parent=$this->root;
                break;
            case '2.0':
                $parent=$this->channel;
                $required=array('link'=>0,'title'=>0);
                $optional=array('description'=>0,'author'=>0,'comments'=>0,'pubDate'=>0,'source'=>0,'category'=>0,'guid'=>0);
                $multiple=array('category'=>1, 'related:item'=>1);
                break;
            default:
                $this->error='it was not specified a supported RSS specification version';
                return 0;
        }
        if(!($this->addtag('item',$attributes,$parent,$path,1)))
            return 0;
        //echo "... addtag ok ...";  //debug
        if(!($this->addrssproperties($properties,$path,$required,$optional,$multiple,'item')))
            return 0;
        //echo "... addrssprop ok ..."; //debug
        if(!strcmp($this->specification,'1.0'))
        {
            if(!strcmp($this->itemsequence,''))
            {
                $attributes=array();
                if(!($this->addtag('items',$attributes,$this->channel,$path,1) && $this->addtag('rdf:Seq',$attributes,$path,$path,1)))
                    return 0;
                $this->itemsequence=$path;
            }
            $attributes=array('rdf:resource'=>$properties['link']);
            if(!($this->addtag('rdf:li',$attributes,$this->itemsequence,$path,0)))
                return 0;
        }
        $this->items++;
        return 1;
    }

    Function addimage(&$properties)
    {
        if(strcmp($this->error,''))
            return 0;
        if(!strcmp($this->channel,''))
        {
            $this->error='the channel was not yet added';
            return 0;
        }
        if(strcmp($this->image,''))
        {
            $this->error='the channel image was already associated';
            return 0;
        }
        if($this->items!=0)
        {
            $this->error='the image can only be defined before adding the channel items';
            return 0;
        }
        $attributes=array();
        switch($this->specification)
        {
            case '0.9':
                $parent=$this->root;
                break;
            case '0.91':
                $parent=$this->channel;
                break;
            case '1.0':
                if(IsSet($properties['url']))
                    $attributes['rdf:about']=$properties['url'];
                $parent=$this->root;
                break;
            case '2.0':
                $parent=$this->channel;
                break;
            default:
                $this->error='it was not specified a supported RSS specification version';
                return 0;
        }
        if(!($this->addtag('image',$attributes,$parent,$path,1)))
            return 0;
        $this->image=$path;
        $required=array('link'=>0,'title'=>0,'url'=>0);
        $optional=array('description'=>0,'width'=>0,'height'=>0);
        $multiple=array();
        if(!($this->addrssproperties($properties,$this->image,$required,$optional,$multiple,'image')))
            return 0;
        if(!strcmp($this->specification,'1.0'))
        {
            $attributes=array('rdf:resource'=>$properties['url']);
            return $this->addtag('image',$attributes,$this->channel,$path,0);
        }
        return 1;
    }

    Function addtextinput(&$properties)
    {
        if(strcmp($this->error,''))
            return 0;
        if(!strcmp($this->channel,''))
        {
            $this->error='the channel was not yet added';
            return 0;
        }
        if(strcmp($this->textinput,''))
        {
            $this->error='the channel text input was already associated';
            return 0;
        }
        if($this->items==0 && !$this->allownoitems)
        {
            $this->error='it were not specified any items before defining the channel text input';
            return 0;
        }
        $attributes=array();
        $tag='textinput';
        switch($this->specification)
        {
            case '0.9':
                $parent=$this->root;
                break;
            case '0.91':
                $parent=$this->channel;
                break;
            case '1.0':
                if(IsSet($properties['link']))
                    $attributes['rdf:about']=$properties['link'];
                $parent=$this->root;
                break;
            case '2.0':
                $parent=$this->channel;
                $tag='textInput';
                break;
            default:
                $this->error='it was not specified a supported RSS specification version';
                return 0;
        }
        if(!($this->addtag($tag,$attributes,$parent,$path,1)))
            return 0;
        $this->textinput=$path;
        $required=array('description'=>0,'link'=>0,'name'=>0,'title'=>0);
        $optional=array();
        $multiple=array();
        if(!($this->addrssproperties($properties,$this->textinput,$required,$optional,$multiple,'textinput')))
            return 0;
        if(!strcmp($this->specification,'1.0'))
        {
            $attributes=array('rdf:resource'=>$properties['link']);
            return $this->addtag('textinput',$attributes,$this->channel,$path,0);
        }
        return 1;
    }

    Function writerss(&$output)
    {
        //echo "start writing RSS <BR>\n"; //debug
        if(strcmp($this->error,''))
        {
            //echo "ERROR ??<BR>\n";  //debug
            return 0;
        }
        if(!strcmp($this->channel,''))
        {
            $this->error='it was not defined the RSS channel';
            //echo "ERROR no channel<BR>\n";  //debug
            return 0;
        }
        if($this->items==0 && !$this->allownoitems)
        {
            $this->error='it were not defined any RSS channel items';
            //echo "ERROR no items<BR>\n";  //debug
            return 0;
        }
        //echo "OK to write RSS <BR>\n"; //debug
        switch($this->specification)
        {
            case '0.9':
                $this->dtdtype='PUBLIC';
                $this->dtddefinition='-//Netscape Communications//DTD RSS 0.9//EN';
                $this->dtdurl='http://my.netscape.com/publish/formats/rss-0.9.dtd';
                break;
            case '0.91':
                $this->dtdtype='PUBLIC';
                $this->dtddefinition='-//Netscape Communications//DTD RSS 0.91//EN';
                $this->dtdurl='http://my.netscape.com/publish/formats/rss-0.91.dtd';
                break;
            case '1.0':
                $this->dtdtype='';
                break;
            case '2.0':
                $this->dtdtype='';
                break;
            default:
                $this->error='it was not specified a supported RSS specification version';
                return 0;
        }

        //echo "writing RSS <BR>\n"; //debug
        return $this->write($output);
    }
};

// ----- End of OpenSearch XML Generator -----------------------------------------------------------


// ----- Utility Functions -------------------------------------------------------------------------



function rss_error($error_message)
{
    Header('Content-Type: text/plain');
    printf("$error_message\n");
    exit;
}