<form class="yearly-payment-form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
    <input type="hidden" name="custom" value="{{ @$custom_code }}">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="943WLK6QHBMUA">
    <input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribe_LG.gif" border="0" name="submit"
           alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
