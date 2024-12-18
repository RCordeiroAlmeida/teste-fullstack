<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel com Bootstrap</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div class="container mt-5">
        <form action="{{ route('clima') }}" method="GET" class="p-4 shadow rounded">
            @csrf 
            <div class="row g-3">
                <!-- Campo para o CEP -->
                <div class="col-sm-3">
                    <label for="cep" class="form-label">Postal Code</label>
                    <input type="text" name="cep" id="cep" class="form-control" placeholder="Digite o CEP" maxlength="9" required>
                </div>

                <!-- Campo para a Cidade -->
                <div class="col-sm-7">
                    <label for="cid" class="form-label">Cidade</label>
                    <input type="text" name="cid" id="cid" class="form-control" placeholder="informe o CEP" readonly required>
                </div>

                <!-- Botão de Submissão -->
                <div class="col-sm-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary fw-bold w-100">Consultar previsão</button>
                </div>
            </div>   
        </form> 

        <div class="container mt-5">
            <div class="p-4 shadow rounded bg-white position-relative">
                <form action="{{ route('save') }}" method="POST">
                    @csrf
                    <!-- Botão no canto superior direito -->
                    <div class="position-absolute top-0 end-0 m-3">
                        <button class="btn fw-bold text-warning" title="Salvar"><i data-lucide="bookmark"></i></button>
                    </div>
                </form>
        
                <!-- Cabeçalho com Localização -->
                <div class="mb-4">
                    <h2>{{ $weather['location']['name'] }}, {{ $weather['location']['region'] }} - {{ $weather['location']['country'] }}</h2>
                    <p class="text-muted">{{ \Carbon\Carbon::parse($weather['location']['localtime'])->format('d/m/Y H:i') }}</p>
                </div>
                
                <!-- Dados principais e Tabela de dados adicionais -->
                <div class="row">
                    <!-- Coluna da esquerda com dados principais -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="row w-100">
                            <div class="col-md-3 text-center">
                                <img src="{{ $weather['current']['weather_icons'][0] }}" alt="Weather Icon" class="img-fluid" style="max-width: 100px;">
                            </div>
                            <div class="col-md-4 text-center">
                                <p class="fs-1 fw-bold">{{ $weather['current']['temperature'] }}°C</p>
                                <p class="h5">{{ $weather['current']['weather_descriptions'][0] }}</p>
                            </div>
                            <div class="col-md-5 text-center">
                                <p class="fs-1 fw-bold">{{ $weather['current']['wind_speed'] }} km/h</p>
                                <p class="h5">Vento</p>
                            </div>
                        </div>
                    </div>
        
                    <!-- Coluna da direita com a tabela de dados adicionais -->
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th>
                                        Pressão
                                        <i data-lucide="wind-arrow-down"></i>
                                    </th>
                                    <td>{{ $weather['current']['pressure'] }} hPa</td>
                                </tr>
                                <tr>
                                    <th>Humidade</th>
                                    <td>{{ $weather['current']['humidity'] }}%</td>
                                </tr>
                                <tr>
                                    <th>Visibilidade</th>
                                    <td>{{ $weather['current']['visibility'] }} km</td>
                                </tr>
                                <tr>
                                    <th>UV Index</th>
                                    <td>{{ $weather['current']['uv_index'] }}</td>
                                </tr>
                                <tr>
                                    <th>Sensação Térmica</th>
                                    <td>{{ $weather['current']['feelslike'] }}°C</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr class="mt-5">
        <h2 class="mb-3">Previsões do tempo salvas</h2>
        <p>Nenhuma previsão foi salva</p>


    </div>
</body>
</html>