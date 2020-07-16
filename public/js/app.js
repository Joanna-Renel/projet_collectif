alert(1);
/*
SUPPRESSION DE DOCUMENTS
*/
const document = document.getElementById('documents');

// Si le document existe, on définit une fonction qui permettra de 
// vérifier que l'utilisateur souhaite bel et bien supprimer le document 
// avant de le supprimer définitivement
if(document)
{
    documents.addEventListener('click', e => {
        if(e.target.className === 'btn btn-danger delete-doc')
        {
            if(confirm('Voulez-vous vraiment supprimer ce document?'))
            {
                const id = e.target.getAttribute('data-id');
                
                //alert(id);
                /*
                Lorsqu'on sélectionne le document à supprimer avec l'id qui lui 
                est associé, on indique qu'on va appliquer la méthode 'DELETE' 
                Lorsque la méthode est appliquée, on attend en réponse le 
                rechargement de la page active

                */
                fetch(`/docs/delete/${id}`, {
                    method: 'DELETE'
                }).then(res => window.location.reload());
                
            }
        }
    });
}