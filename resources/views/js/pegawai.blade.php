@if (Route::currentRouteName() == 'pegawai')
    @if (count($errors) > 0)
        <script>
            const myModalAlternative = new bootstrap.Modal('#modalCreateEmployee', {})
            myModalAlternative.show()
        </script>
    @endif
    <script>
        const npp = $("#nppDataList");

        const employee = {{ Js::from($pegawai) }}

        npp.click(function() {
            npp.val('');
        }).keyup(function() {
            let findEmployee = employee.find(element => {
                return this.value == element.npp
            })

            if (findEmployee) {
                $('#nama').val(findEmployee.nama)
                $('#npwp').val(findEmployee.npwp)
                $("#st_ptkp option[value='" + findEmployee.st_ptkp + "']").attr("selected", "selected");
            } else {
                $('#nama').val('')
                $('#npwp').val('')
                $("#st_ptkp option").removeAttr("selected");
            }
        })
    </script>
@endif
