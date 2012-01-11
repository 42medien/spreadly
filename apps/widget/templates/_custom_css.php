<?php
use_helper('Color');
$hls = rgb2hsl($sf_user->getAttribute("popup_color", "973765", "persistent"));
?>

<style type="text/css">
  input, textarea {
    border: 1px solid hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.7); /*whatever the skin color is*/
  }

  #content-outer {
    background-color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1); /*whatever the skin color is*/
  }

  #content-outer h1 {
    border-bottom: 1px dotted hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1);
  }

  textarea::-webkit-scrollbar-thumb {
    background-color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.5); /*whatever the skin color is*/
  }

  textarea::-webkit-scrollbar-thumb:hover {
    background-color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1); /*whatever the skin color is*/
  }

  #deal-marker {
    background-color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1);
    color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,100%,1);
  }

  #redeemcode, div#like-submit a.addservice {
    color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1);
  }

  #redeemcode:hover {
    color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,0%,1);
  }

  #redeemcode::selection {
    background: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1);
    color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,90%,1);
  }

  div#like-submit{
    border-top: 1px dotted hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.4);
    background: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.1);
  }

  div#like-submit:hover{
    border-top: 1px dotted hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1);
    background: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.3);
  }

  #like-oi-list a {
    color: hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%);
  }

  .B {
    color: hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%);  /* #B44A7A */
    border: 1px solid hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,73%);
    border-bottom-color: hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%);
    border-top-color: hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,81%);
    box-shadow: 0 -1px 1px 1px hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>,100%,.7) inset, 0 -4px 8px 0 hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.5) inset, 0 0 2px 4px hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,0%,0);
    text-shadow: 0 1px 1px #fff, 0 -1px 1px hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.25);
  }
  .B:before{
    background-color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,1);
    box-shadow: 0 1px 1px 0px hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,0%,.8) inset;
  }

  .B:focus, .B:hover{
    border: 1px solid hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,65%);
    border-top-color: hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,46%);
    box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.3) inset, 0 0 4px 0 hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,30%,.5);
    text-shadow: 0 1px 1px hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.25), 0 -1px 1px #fff;
  }

  .B:active {
    background-color: hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,70%,1);
    border-color: hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,30%);
    border-top-color: hsl(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,30%);
    box-shadow: 0 0 0 1px #fff inset, 0 6px 12px 0 hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,.3) inset, 0 0 4px 0 hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,30%,.5);
    text-shadow: 0 0px 0px hsla(<?php echo $hls[0]; ?>,<?php echo $hls[2] ?>%,50%,0), 0 0px 0px #fff;
  }
</style>