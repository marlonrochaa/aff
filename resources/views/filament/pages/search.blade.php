<x-filament-panels::page>
 <div class="bg-gray-200 p-2 border rounded-lg border-rounded-lg">
      <form action="{{ route('get.tax') }}" method="POST">
         @csrf
         <div class="flex flex-col">
            <label for="ncm">NCM</label>
            <input type="text" name="ncm" id="ncm" class="p-2 border rounded-lg border-gray-300">
         </div>
         <div class="flex flex-col">
            <label for="tipoitem">Tipo de Item</label>
            <input type="text" name="tipoitem" id="tipoitem" class="p-2 border rounded-lg border-gray-300">
         </div>
         <div class="flex flex-col">
            <label for="estadoorigem">Estado de Origem</label>
            <input type="text" name="estadoorigem" id="estadoorigem" class="p-2 border rounded-lg border-gray-300">
         </div>
         <div class="flex flex-col">
            <label for="estadodestino">Estado de Destino</label>
            <input type="text" name="estadodestino" id="estadodestino" class="p-2 border rounded-lg border-gray-300">
         </div>
         <div class="flex flex-col">
            <label for="entradasaida">Entrada ou Saída</label>
            <input type="text" name="entradasaida" id="entradasaida" class="p-2 border rounded-lg border-gray-300">
         </div>
        <button type="button" id="post" class="bg-blue-500 text-white p-2 border rounded-lg border-gray-300 mt-4">Buscar</button>
      </form>
 </div>
   <!-- importa o axios -->
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   <script>
      document.getElementById('post').addEventListener('click', function (e) {
         e.preventDefault();
         let ncm = document.getElementById('ncm').value;
         let tipoitem = document.getElementById('tipoitem').value;
         let estadoorigem = document.getElementById('estadoorigem').value;
         let estadodestino = document.getElementById('estadodestino').value;
         let entradasaida = document.getElementById('entradasaida').value;
         axios.post('/tax', {
            ncm: ncm,
            tipoitem: tipoitem,
            estadoorigem: estadoorigem,
            estadodestino: estadodestino,
            entradasaida: entradasaida
         })
            .then(function (response) {
               console.log(response);
            })
            .catch(function (error) {
               console.log(error);
            });
      });
   </script>
</x-filament-panels::page>
                                                                        