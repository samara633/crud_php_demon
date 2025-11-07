// ---------------------------------------------------
// servicios.js - CRUD Servicios
const apiServicios = 'servicios.php';

async function cargarServicios() {
  const res = await fetch(apiServicios);
  const data = await res.json();
  const tbody = document.querySelector('#tablaServicios tbody');
  tbody.innerHTML = '';
  data.forEach(s => {
    tbody.innerHTML += `
      <tr>
        <td>${s.id}</td>
        <td>${s.nombre}</td>
        <td>${s.descripcion}</td>
        <td>${s.costo}</td>
        <td>
          <button class='btn btn-warning btn-sm' onclick='editarServicio(${JSON.stringify(s)})'>Editar</button>
          <button class='btn btn-danger btn-sm' onclick='eliminarServicio(${s.id})'>Eliminar</button>
        </td>
      </tr>`;
  });
}

document.getElementById('servicioForm')?.addEventListener('submit', async e => {
  e.preventDefault();
  const id = document.getElementById('servicioId').value;
  const data = {
    id,
    nombre: document.getElementById('nombre').value,
    descripcion: document.getElementById('descripcion').value,
    costo: document.getElementById('costo').value
  };
  const method = id ? 'PUT' : 'POST';
  await fetch(apiServicios, { method, body: JSON.stringify(data) });
  cargarServicios();
  e.target.reset();
});

function editarServicio(s) {
  document.getElementById('servicioId').value = s.id;
  document.getElementById('nombre').value = s.nombre;
  document.getElementById('descripcion').value = s.descripcion;
  document.getElementById('costo').value = s.costo;
}

async function eliminarServicio(id) {
  await fetch(apiServicios, { method: 'DELETE', body: JSON.stringify({ id }) });
  cargarServicios();
}

cargarServicios();