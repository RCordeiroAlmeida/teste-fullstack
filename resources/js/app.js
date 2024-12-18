import './bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css'; // Estilos do Bootstrap
import 'bootstrap/dist/js/bootstrap.bundle.min.js'; // JavaScript do Bootstrap 
import axios from 'axios';

import { createIcons, icons } from 'lucide';

createIcons({ icons });


document.addEventListener('DOMContentLoaded', () =>{
    const inputCep = document.getElementById('cep');
    const inputCid = document.getElementById('cid');

    cep.addEventListener('blur', async () =>{
        const cep = inputCep.value.replace(/\D/g, ''); // para remover os caracteres que não sejam numéricos

        if(cep.length === 8 && /^[0-9]{8}$/.test(cep)){ // testa se tem 8 digitos numericos
            try{
                const response = await axios.get(`https://viacep.com.br/ws/${cep}/json/`);// faz a requisição na api viaCEP com o cep passado

                if(response.data.erro){
                    inputCid.value = 'Não encontrado';
                    //inserir sweet alert
                }else{
                    inputCid.value = response.data.localidade && response.data.uf
                    ? `${response.data.localidade}, ${response.data.uf}`
                    : '';
                }
            } catch (error){
                alert('ERRO');
                console.log(error);
            }
        }
    });
});