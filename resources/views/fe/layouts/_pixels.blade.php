<!-- Google Tag Manager -->
<script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KF37SJR');
</script>
<!-- End Google Tag Manager -->

<!-- Global site tag (gtag.js) - Google Ads: 820117085 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-820117085"></script>
<script>
    window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'AW-820117085');
</script>

<!-- Event snippet for Purchase conversion page
In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->
<script>
    function gtag_report_conversion() {
        gtag('event', 'conversion', {
            'send_to': 'AW-820117085/NDCHCKmSxdABEN38h4cD',
            'value': 1.0,
            'currency': 'USD',
            'transaction_id': ''
        });
        return false;
    }
</script>

<script>
    !function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMetPhod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '322980745804403'); 
fbq('track', 'PageView');
</script><noscript> <img height="1" width="1" src="https://www.facebook.com/tr?id=322980745804403&ev=PageView
&noscript=1" /></noscript>

<!-- trkng -->
<script>
    !function(e,t,n,p,s,a,o,c,i){e[s]||(o=e[s]=function(){o.process?o.process.apply(o,arguments):o.queue.push(arguments)},o.queue=[],o.t=1*new Date,c=t.createElement(n),c.async=1,c.src=p+"?t="+Math.ceil(new Date/a)*a,i=t.getElementsByTagName(n)[0],i.parentNode.insertBefore(c,i))}(window,document,"script","https://trk.dzr.io/v1/pixel.min.js","dz",864e5),dz("init","ID-d474cz4r"),
@if (!empty($tracking)) 
    dz('event', 'pageload', '{!! json_encode($tracking) !!}');
@else
    dz('event', 'pageload');
@endif
</script><!-- end trkng -->

{{-- Microsoft --}}
<script>
    (function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"134002213"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");
</script>
<script>
    function msft_report_conversion() {
        window.uetq = window.uetq || []; window.uetq.push({ 'ec': 'Money', 'ea': 'Purchase', 'el': 'Order', 'ev': 1 });
    }
</script>    
{{-- Microsoft --}}