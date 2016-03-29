function cambiar(variable)
{
    switch (variable) {
        case 1:
            document.getElementById('form_paso_b').style.display = 'none';
            document.getElementById('form_paso_a').style.display = 'block';
            document.getElementById('form_paso_d').style.display = 'none';
            break;
        case 2:
            
            document.getElementById('form_paso_a').style.display = 'none';
            document.getElementById('form_paso_c').style.display = 'none';
            document.getElementById('form_paso_b').style.display = 'block';
            document.getElementById('form_paso_d').style.display = 'none';
            break;
        case 3:
            document.getElementById('form_paso_a').style.display = 'none';
            document.getElementById('form_paso_b').style.display = 'none';
            document.getElementById('form_paso_c').style.display = 'block';
            document.getElementById('form_paso_d').style.display = 'none';
            break;
        case 4:
            document.getElementById('form_paso_a').style.display = 'none';
            document.getElementById('form_paso_b').style.display = 'none';
            document.getElementById('form_paso_c').style.display = 'none';
            document.getElementById('form_paso_d').style.display = 'block';
            break;
    }
}


