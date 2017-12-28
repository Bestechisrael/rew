<?php
$styleOptions = array(
'custom' => 'Custom',
'kubrick' => 'Kubrick',
'twentyten' => 'Twenty Ten',
'block' => 'Block',
'noarrows' => 'No arrows'
);

$defaultStyles= array(
'custom' => get_option('collapsArchStyle'), 
'kubrick' => "{ID} span.acollapsing.archives {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
} 

{ID} li.widget_collapspage h2 span.sym {float:right;padding:0 .5em}
{ID} li.acollapsing.archives a.self {font-weight:bold}
{ID}:before {content:'';} 
{ID}  li.acollapsing.archives:before {content:'';} 
{ID}  li.acollapsing.archives {list-style-type:none}
{ID}  li.acollapsing.archives{
       padding:0 0 0 1em;
       text-indent:-1em;
}
{ID} li.acollapsing.archives.item:before {content: '\\00BB \\00A0' !important;} 
{ID} li.acollapsing.archives .sym {
   cursor:pointer;
   font-size:1.2em;
   font-family:Arial, Helvetica, sans-serif;
    padding-right:5px;}",

'block' => "{ID} li a {
            display:block;
            text-decoration:none;
            margin:0;
            width:100%;
            padding:0 10em 0 1em;
            }
{ID}.acollapsing.archives, {ID} li.acollapsing.archives ul {
margin-left:0;
padding:0;

}
{ID} li li a {
padding-left:1em;
}
{ID} li li li a {
padding-left:2em;
}
{ID} li a:hover {
            text-decoration:none;
          }
{ID} span.acollapsing.archives {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
}

{ID} li.widget_collapspage h2 span.sym {float:right;padding:0 .5em}
{ID} span.sym {
float:right;
}
{ID} li.acollapsing.archives a.self {
 font-weight:bold;
}
{ID}:before {content:'';} 
{ID} li.acollapsing.archives {
list-style-type:none;
}
{ID} li.acollapsing.archives.item:before, 
  {ID} li.acollapsing.archives:before {
       content:'';
  } 
{ID}  li.acollapsing.archives .sym {
  /*
   cursor:pointer;
   font-size:1.2em;
   font-family:Arial, Helvetica, sans-serif;
    float:left;
    padding-right:5px;
    */
}",

'twentyten' => "
{ID} span.acollapsing.archives {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
} 

{ID} h3 span.sym {float:right;padding:0 .5em}
{ID} li.acollapsing.archives a.self {font-weight:bold}
{ID}:before {content:'';} 
{ID} li.acollapsing.archives.expand:before {content:'';} 
{ID} li.acollapsing.archives.expand,
{ID} li.acollapsing.archives.acollapse {
       list-style:none;
       padding:0 0 0 .9em;
       margin-left:-1em;
       text-indent:-1.1em;
}
{ID} li.acollapsing.archives.item {
  padding:0;
  text-indent:0;
}

{ID} li.acollapsing.archives .sym {
   cursor:pointer;
   font-size:1.2em;
   font-family:Arial, Helvetica, sans-serif;
    padding-right:5px;}
",


'noArrows'=>
"{ID} span.acollapsing.archives {
        border:0;
        padding:0; 
        margin:0; 
        cursor:pointer;
}
{ID} li.acollapsing.archives a.self {font-weight:bold}

{ID} li.widget_collapspage h2 span.sym {float:right;padding:0 .5em}
{ID}:before {content:'';} 
{ID} li.acollapsing.archives:before {content:'';} 
{ID} li.acollapsing.archives {list-style-type:none}
{ID} li.acollapsing.archives .sym {
   cursor:pointer;
   font-size:1.2em;
   font-family:Arial, Helvetica, sans-serif;
    padding-right:5px;"
    );
?>
