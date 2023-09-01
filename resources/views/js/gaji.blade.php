@if (Route::currentRouteName() == 'gaji')
    @if (count($errors) > 0)
        <script>
            const myModalAlternative = new bootstrap.Modal('#modalCreateSalary', {})
            myModalAlternative.show()
        </script>
    @endif
    <script>
        const npp = $("#nppDataList");

        const employee = {{ Js::from($pegawai) }}

        const salary = {{ Js::from($gaji) }}

        npp.click(function() {
            npp.val('');
        }).keyup(function() {

            let findEmployee = employee.find(element => {
                return this.value == element.npp
            });

            let findSalary = salary.find(element => {
                return this.value == element.npp
            });

            if (findEmployee) {
                npp.removeClass('is-invalid').addClass('is-valid')
                $('#nama').val(findEmployee.nama)
                $("#st_ptkp").val(findEmployee.st_ptkp);
            } else {
                npp.removeClass('is-valid').addClass('is-invalid');
                $('#nama').val("")
                $('#st_ptkp').val("")
            }

            if (findSalary) {
                $('#gapok').val(findSalary.gapok)
                $('#tj_kelu').val(findSalary.tj_kelu)
                $('#tj_pend').val(findSalary.tj_pend)
                $('#tj_jbt').val(findSalary.tj_jbt)
                $('#tj_alih').val(findSalary.tj_alih)
                $('#tj_kesja').val(findSalary.tj_kesja)
                $('#tj_beras').val(findSalary.tj_beras)
                $('#tj_rayon').val(findSalary.tj_rayon)
                $('#tj_makan').val(findSalary.tj_makan)
                $('#tj_sostek').val(findSalary.tj_sostek)
                $('#tj_kes').val(findSalary.tj_kes)
                $('#tj_dapen').val(findSalary.tj_dapen)
                $('#tj_hadir').val(findSalary.tj_hadir)
                $('#tj_bhy').val(findSalary.tj_bhy)
                $('#tj_lainnya').val(findSalary.tj_lainnya)
                $('#thr').val(findSalary.thr)
                $('#bonus').val(findSalary.bonus)
                $('#lembur').val(findSalary.lembur)
                $('#kurang').val(findSalary.kurang)
            } else {
                $('#gapok').val(0)
                $('#tj_kelu').val(0)
                $('#tj_pend').val(0)
                $('#tj_jbt').val(0)
                $('#tj_alih').val(0)
                $('#tj_kesja').val(0)
                $('#tj_beras').val(0)
                $('#tj_rayon').val(0)
                $('#tj_makan').val(0)
                $('#tj_sostek').val(0)
                $('#tj_kes').val(0)
                $('#tj_dapen').val(0)
                $('#tj_hadir').val(0)
                $('#tj_bhy').val(0)
                $('#tj_lainnya').val(0)
                $('#thr').val(0)
                $('#bonus').val(0)
                $('#lembur').val(0)
                $('#kurang').val(0)
            }
        })
    </script>
@endif
