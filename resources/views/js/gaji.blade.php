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
                $('#gapok').val(findSalary.gapok ?? 0)
                $('#tj_kelu').val(findSalary.tj_kelu ?? 0)
                $('#tj_pend').val(findSalary.tj_pend ?? 0)
                $('#tj_jbt').val(findSalary.tj_jbt ?? 0)
                $('#tj_alih').val(findSalary.tj_alih ?? 0)
                $('#tj_kesja').val(findSalary.tj_kesja ?? 0)
                $('#tj_beras').val(findSalary.tj_beras ?? 0)
                $('#tj_rayon').val(findSalary.tj_rayon ?? 0)
                $('#tj_makan').val(findSalary.tj_makan ?? 0)
                $('#tj_sostek').val(findSalary.tj_sostek ?? 0)
                $('#tj_kes').val(findSalary.tj_kes ?? 0)
                $('#tj_dapen').val(findSalary.tj_dapen ?? 0)
                $('#tj_hadir').val(findSalary.tj_hadir ?? 0)
                $('#tj_bhy').val(findSalary.tj_bhy ?? 0)
                $('#tj_lainnya').val(findSalary.tj_lainnya ?? 0)
                $('#thr').val(findSalary.thr ?? 0) 
                $('#bonus').val(findSalary.bonus ?? 0) 
                $('#lembur').val(findSalary.lembur ?? 0) 
                $('#kurang').val(findSalary.kurang ?? 0) 
                $('#pot_dapen').val(findSalary.pot_dapen ?? 0) 
                $('#pot_sostek').val(findSalary.pot_sostek ?? 0) 
                $('#pot_kes').val(findSalary.pot_kes ?? 0) 
                $('#pot_swk').val(findSalary.pot_swk ?? 0) 
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
                $('#pot_dapen').val(0) 
                $('#pot_sostek').val(0) 
                $('#pot_kes').val(0) 
                $('#pot_swk').val(0) 
            }
        })
    </script>
@endif
