<?php 
    if(isset($midApi['snapToken'])){
    $snapToken = $midApi['snapToken'];
    $snapURL = $midApi['snapURL'];
    $ckey = $midApi['ckey'];
?>
<script src='<?=$snapURL?>' data-client-key='<?=$ckey?>'></script>
<script language="javascript">
    setTimeout(function() {
        snap.pay('<?=$snapToken?>', {
            onSuccess: function(result){console.log('success');console.log(result);window.location.replace(result.finish_redirect_url);},
            onPending: function(result){console.log('pending');console.log(result);window.location.replace(result.finish_redirect_url);},
            onError: function(result){console.log('error');console.log(result);window.location.replace(result.finish_redirect_url);},
            onClose: function(){console.log('customer closed the popup without finishing the payment');}
        }) 
    }, 2000);
</script>
<?php }else{
    echo 'error data';
}
?>