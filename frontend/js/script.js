// script.js - CRUD Pedidos
const apiPedidos = 'pedido.php';

async function cargarPedidos() {
  const res = await fetch(apiPedidos);
  const data = await res.json();
  const tbody = document.querySelector('#tablaPedidos tbody');
  tbody.innerHTML = '';
  data.forEach(p => {
    tbody.innerHTML += `
      <tr>
        <td>${p.id}</td>
        <td>${p.cliente}</td>
        <td>${p.producto}</td>
        <td>${p.cantidad}</td>
        <td>
          <button class='btn btn-warning btn-sm' onclick='editarPedido(${JSON.stringify(p)})'>Editar</button>
          <button class='btn btn-danger btn-sm' onclick='eliminarPedido(${p.id})'>Eliminar</button>
        </td>
      </tr>`;
  });
}

document.getElementById('pedidoForm').addEventListener('submit', async e => {
  e.preventDefault();
  const id = document.getElementById('pedidoId').value;
  const data = {
    id,
    cliente: document.getElementById('cliente').value,
    producto: document.getElementById('producto').value,
    cantidad: document.getElementById('cantidad').value
  };
  const method = id ? 'PUT' : 'POST';
  await fetch(apiPedidos, { method, body: JSON.stringify(data) });
  cargarPedidos();
  e.target.reset();
});

function editarPedido(p) {
  document.getElementById('pedidoId').value = p.id;
  document.getElementById('cliente').value = p.cliente;
  document.getElementById('producto').value = p.producto;
  document.getElementById('cantidad').value = p.cantidad;
}

async function eliminarPedido(id) {
  await fetch(apiPedidos, { method: 'DELETE', body: JSON.stringify({ id }) });
  cargarPedidos();
}

cargarPedidos();


