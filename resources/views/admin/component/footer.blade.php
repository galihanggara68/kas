<!-- Footer -->
<footer class="sticky-footer bg-white mt-5">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; {{App\Setting::where('slug','nama-toko')->get()->first()->description}} {{date('Y')}} | Created by <a href='#' title='Namira Kaltsum Nadaa' target='_blank'>Namira Kaltsum Nadaa</a>
            </span>
        </div>
    </div>
</footer>
<!-- End of Footer -->
