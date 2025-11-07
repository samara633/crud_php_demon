// ---------------------------------------------------
// productos.js - CRUD Productos
const apiProductos = 'productos.php';

async function cargarProductos() {
  const res = await fetch(apiProductos);
  const data = await res.json();
  const tbody = document.querySelector('#tablaProductos tbody');
  tbody.innerHTML = '';
  data.forEach(p => {
    tbody.innerHTML += `
      <tr>
        <td>${p.id}</td>
        <td>${p.nombre}</td>
        <td>${p.descripcion}</td>
        <td>${p.precio}</td>
        <td>
          <button class='btn btn-warning btn-sm' onclick='editarProducto(${JSON.stringify(p)})'>Editar</button>
          <button class='btn btn-danger btn-sm' onclick='eliminarProducto(${p.id})'>Eliminar</button>
        </td>
      </tr>`;
  });
}

document.getElementById('productoForm')?.addEventListener('submit', async e => {
  e.preventDefault();
  const id = document.getElementById('productoId').value;
  const data = {
    id,
    nombre: document.getElementById('nombre').value,
    descripcion: document.getElementById('descripcion').value,
    precio: document.getElementById('precio').value
  };
  const method = id ? 'PUT' : 'POST';
  await fetch(apiProductos, { method, body: JSON.stringify(data) });
  cargarProductos();
  e.target.reset();
});

function editarProducto(p) {
  document.getElementById('productoId').value = p.id;
  document.getElementById('nombre').value = p.nombre;
  document.getElementById('descripcion').value = p.descripcion;
  document.getElementById('precio').value = p.precio;
}

async function eliminarProducto(id) {
  await fetch(apiProductos, { method: 'DELETE', body: JSON.stringify({ id }) });
  cargarProductos();
}

cargarProductos();

