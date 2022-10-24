 <!-- Footer -->
 <div class="footer">
    <div class="footer_box">
        <div class="footer_box1">
            <div class="ft_box1_first">
                <div class="footer_title">
                    contact us
                </div>
                <div class="footer_content">
                    <div class="footer_item">
                        <div class="footer_item_img">
                            <img src="{{asset('template')}}/images/footer_phone.png" alt="">
                        </div>
                        <div class="footer_item_content">(01) 23 456 789</div>
                    </div>
                    <div class="footer_item">
                        <div class="footer_item_img">
                            <img src="{{asset('template')}}/images/footer_email.png" alt="">
                        </div>
                        <div class="footer_item_content">support.fashion@gmail.com</div>
                    </div>
                    <div class="footer_item">
                        <div class="footer_item_img">
                            <img src="{{asset('template')}}/images/footer_map.png" alt="">
                        </div>
                        <div class="footer_item_content">254 Milacina Streets, Behansed Tower, London</div>
                    </div>
                </div>
            </div>
            <div class="ft_box1_second">
                <div class="ft_b1_second_left">
                    <div class="footer_title">
                        GET HELP
                    </div>
                    <div class="footer_content">
                        <div class="footer_item">
                            <div class="footer_item_content">Privacy Policy</div>
                        </div>
                        <div class="footer_item">
                            <div class="footer_item_content">Customer Service</div>
                        </div>
                        <div class="footer_item">
                            <div class="footer_item_content">Payment options</div>
                        </div>
                    </div>
                </div>
                <div class="ft_b1_second_right">
                    <div class="footer_title">
                        quick Link
                    </div>
                    <div class="footer_content">
                        <div class="footer_item">
                            <div class="footer_item_content">About us</div>
                        </div>
                        <div class="footer_item">
                            <div class="footer_item_content">Shop</div>
                        </div>
                        <div class="footer_item">
                            <div class="footer_item_content">Cart</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ft_box1_end">
                <div class="ft_b1_second_left">
                    <div class="footer_title">
                        SUBCRIbE FOR OUR NEWSLETTER
                    </div>
                    <div class="footer_content">
                        <div class="footer_item_content2">
                            <input type="text" placeholder="youremail.@gmail.com">
                            <div class="submit_footer">Submit</div>
                        </div>
                        <div class="footer_network">
                            <a href="#"> <img src="{{asset('template')}}/images/instagram.png"></a>
                            <a href="#"> <img src="{{asset('template')}}/images/facebook.png"></a>
                            <a href="#"> <img src="{{asset('template')}}/images/linkedin.png"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer_box2">
            <div class="footer_box2_item">
                ©2022 Fashion Designer, Adamo Software
            </div>
            <div class="footer_box2_item">
                <img src="{{asset('template')}}/images/cash.png">
                <img src="{{asset('template')}}/images/visa.png">
                <img src="{{asset('template')}}/images/paypal.png">
            </div>
        </div>
    </div>
</div>
<!-- End footer -->

<script type="text/javascript" src="{{asset('template')}}/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('admins')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{asset('template')}}/js/header.js"></script>
@yield('js')

</body>

</html>