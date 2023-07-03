import Swal from "sweetalert2"
import axios from "axios";

document.querySelectorAll('#delete-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {

        const project = JSON.parse(e.currentTarget.dataset.project)
        Swal.fire({
            text: `Do you want to delete "${project.title}"?`,
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#cf2e0a'
        }).then((result) => {
            // delete if confirmed
          if (result.isConfirmed) {

            axios.delete(`/projects/${project.id}`) // delete request

            location.reload()   // reload
          }
        })
    })
})
