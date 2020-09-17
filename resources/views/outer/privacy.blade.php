@extends('layout.frontend.outer.header') @section('content')
<div class="fullscreen landing parallax" style="background-image:url('{{asset('newtheme/images/bg.jpeg')}}');" data-img-width="2000" data-img-height="1325" data-diff="100">

        <div class="overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mr-auto ml-auto text-center">

                        <!-- /.logo -->
                        <div class="logo wow fadeInDown"> <a href=""><img src="{{asset('newtheme/images/logo1.png')}}" alt="logo"></a></div>
                        <!-- /.main title -->
                        <h2 class="wow fadeInLeft">
                            {{_i('CONFIDENTIALITY DECLARATION')}}
                        </h2>

                        <!-- /.header paragraph -->
                        <div class="landing-text wow fadeInLeft">
                            <p>{{_i('Please read these Terms carefully, and contact us if you have any questions')}}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- /.feature section -->
    <div id="policy">
        <div class="container">
            <div class="row">
                <!-- /.apple devices image -->
                <div class="col-lg-10 mr-auto ml-auto">
                    <p>
                        {{_i('ARTICLE 1 - PERSONAL INFORMATION COLLECTED')}}
                    </p>
                    <ul>
                        <li>{{_i('When you make a purchase on our website, as part of our buying and selling process, we collect the personal information you provide to us, such as your name and email address')}}.</li>

                        <li>{{_i('When you browse our site, we also automatically receive your computers Internet Protocol (IP) address, which allows us to get more details about the browser and operating system you are using.')}}</li>

                        <li>{{_i('Email marketing: With your permission, we may send you e-mails about our website, services, new products and other updates.')}}</li>
                    </ul>







                     <p>
                        {{_i('ARTICLE 2 - CONSENT')}}
                    </p>

                    <p>{{_i('How do you get my consent?')}}</p>
                    <ul>
                        <li>{{_i('When you provide us with your personal information to complete a transaction, check your credit card, place an order, schedule a delivery, or return a purchase, we assume that you agree to us collecting your information and using it for that purpose only.')}}.</li>

                        <li>{{_i('If we ask you to provide us with your personal information for another reason, for marketing purposes for example, we will ask you directly for your explicit consent, or we will give you the opportunity to defer.')}}</li>
                    </ul>
                    <p>{{_i('How can I withdraw my consent?')}}</p>

                    <ul>
                        <li>{{_i('If after having given us your consent, you change your mind and do not allow us to contact you, collect your information or divulge it, you can notify us by contacting us at support@digitalkheops.com or by mail to: Management Danny Cyr Inc. 129 RueA-Guindon, St-therese, QC, J7E 5P1, Canada')}}.</li>
                    </ul>









                    <p>
                        {{_i('ARTICLE 3 - DISCLOSURE')}}
                    </p>
                    <ul>
                        <li>{{_i('We may disclose your personal information if we are required by law to do so or if you violate our Terms and Conditions of Sale and Use.')}}.</li>
                    </ul>



                    <p>
                        {{_i('Payment')}}
                    </p>
                    <ul>
                        <li>{{_i('If you make your purchase through a direct payment gateway, in this case Digital Kheops will store your credit card information. This information is encrypted in accordance with the data security standard established by the payment card industry (PCI-DSS). The information related to your purchase transaction is kept as long as necessary to finalize your order. Once your order is finalized, the information relating to the purchase transaction is deleted.')}}.</li>
                        <li> {{_i('All direct payment gateways comply with the PCI-DSS standard, managed by the PCI Security Standards Board, which is the result of joint corporate efforts such as Visa, MasterCard, American Express and Discover.')}}</li>
                        <li>{{_i('PCI-DSS requirements ensure the secure processing of credit card data by our store and service providers.')}}</li>
                        <li>{{_i('For more information, please see the DigitalKheops Terms of Use here or the Privacy Policy here.')}}</li>
                    </ul>

                    <p>
                        {{_i('ARTICLE 5 - SERVICES PROVIDED BY THIRD PARTIES')}}
                    </p>
                    <ul>
                        <li>{{_i('In general, the third party providers we use will only collect, use and disclose your information to the extent necessary to perform the services they provide to us.')}}.</li>
                        <li>{{_i('However, some third-party service providers, such as payment gateways and other payment transaction processors, have their own privacy policies regarding the information we are required to provide to them for your purchase transactions.')}}</li>
                        <li>{{_i('With respect to these providers, we recommend that you carefully read their privacy policies so that you understand how they will treat your personal information.')}}</li>
                        <li>{{_i('It should be remembered that some providers may be located or have facilities located in a different jurisdiction than you or ours. So if you decide to pursue a transaction that requires the services of a supplier, your information may then be governed by the laws of the jurisdiction in which that provider is located or those of the jurisdiction in which its facilities are located.')}}</li>
                        <li>{{_i('For example, if you are located in Canada and your transaction is processed by a US-based payment gateway, the information you own that was used to close the transaction could be disclosed under US law. , including the Patriot Act.')}}</li>
                        <li>{{_i('Once you leave our website or are redirected to the website or the application of a third party, you are no longer governed by this Privacy Policy or by the Terms and Conditions of Sale and Use of our website.')}}</li>
                    </ul>
                    <p>{{_i('Connections')}}</p>
                    <ul>
                        <li>{{_i('You may have to leave our website by clicking on some of the links on our site. We do not assume any responsibility for the privacy practices of these other sites and we strongly recommend that you follow their privacy policies.')}}.</li>
                    </ul>


                    <p>
                        {{_i('ARTICLE 6 - SECURITY')}}
                    </p>
                    <ul>
                        <li>{{_i('To protect your personal information, we take reasonable precautions and follow industry best practices to ensure that they are not lost, misappropriated, accessed, disclosed, altered or inappropriately destroyed.')}}.</li>
                        <li>{{_i('If you provide us with your credit card information, they will be encrypted through the use of the SSL security protocol and stored with AES-256 encryption. Although no method of Internet transmission or electronic storage is 100% secure, we follow all the requirements of the PCI-DSS and implement additional standards generally recognized by the industry.')}}</li>
                        
                    </ul>



                    <p>
                        {{_i('ARTICLE 7 - AGE OF CONSENT')}}
                    </p>
                    <ul>
                        <li>{{_i('By using this site, you represent that you are at least the age of majority in your state or province of residence, and that you have given us your consent to allow any dependent minor to use this website.')}}.</li>
                        
                    </ul>


                     <p>
                        {{_i('ARTICLE 8 - AMENDMENTS TO THIS DECONFIDENTIALITY POLICY')}}
                    </p>
                    <ul>
                        <li>{{_i('We reserve the right to modify this Privacy Policy at any time, so please check it frequently. Changes and clarifications will take effect immediately upon posting on the website. If we make any changes to the contents of this policy, we will notify you here that it has been updated, so that you know what information we collect, how we use it, and under what circumstances we disclose it, if there is any instead of doing it.')}}.</li>
                        <li>{{_i('If our website and platform is acquired by or through a merger with another company, your information may be transferred to the new owners so that we may continue to sell you products and services.')}}</li>
                        
                    </ul>



                    <p>
                        {{_i('QUESTIONS AND CONTACT')}}
                    </p>
                    <ul>
                        <li>{{_i('If you wish to: access, correct, modify or delete any personal information we have about you, file a complaint, or if you simply want more information, contact a member of the Digital Kheops Academy team and responsible for privacy standards at support@digitalKheops.com or by mail at Gestion Danny Cyr Inc.')}}.</li>
                        <li>{{_i('[Re: Privacy Standards Officer]')}}</li>
                        <li>{{_i('[129 A-Guindon Street, St-Therese, QC, J7E 5P1, Canada]')}}</li>
                        
                    </ul>

                    <div class="text-center"><a href="{{route('home')}}">Back to Main Page</a></div>
                </div>


            </div>
        </div>
    </div>
@endsection