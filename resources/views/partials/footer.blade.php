@if (Request::is('laporankerusakanpage') || Request::is('pembatalanpage'))
    <footer class="bg-dark p-3 fixed-bottom">
@else
    <footer class="bg-dark p-3">
@endif
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-md-6 text-center">
                <img src="/Assets/Logo_Unib.png" alt="Company Logo" class="img-fluid" style="max-width: 40px; height: auto;">
            </div>
            <div class="col-md-6 text-center">
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="https://www.facebook.com/telkomuniversity"><img src="/Assets/face.png" alt="" class="img-fluid" style="max-width: 30px; height: auto;"></a></li>
                    <li class="list-inline-item"><a href="https://www.instagram.com/telkomuniversity/"><img src="/Assets/insta.png" alt="" class="img-fluid" style="max-width: 30px; height: auto;"></a></li>
                    <li class="list-inline-item"><a href="https://www.linkedin.com/school/telkom-university/"><img src="/Assets/Linked.png" alt="" class="img-fluid" style="max-width: 30px; height: auto;"></a></li>
                    <li class="list-inline-item"><a href="https://twitter.com/TelUniversity"><img src="/Assets/twit.png" alt="" class="img-fluid" style="max-width: 30px; height: auto;"></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
