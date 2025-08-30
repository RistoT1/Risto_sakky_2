const form = document.querySelector('form');
const rentedMoviesContainer = document.getElementById('rentedMovies');
const selectOption = document.getElementById('movie');

const fetchMovies = async () => {
    try {
        const response = await fetch('./../api/fetchMovies.php', { method: 'GET' });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            console.error('Network response was not ok.', errorData.message || '');
            return;
        }

        const result = await response.json();
        const movies = result.data || [];

        selectOption.innerHTML = '';

        const defaultOption = document.createElement('option');
        defaultOption.value = 0;
        defaultOption.textContent = 'Valitse elokuva';
        selectOption.appendChild(defaultOption);

        if (!Array.isArray(movies) || movies.length === 0) {
            const option = document.createElement('option');
            option.textContent = 'No movies available';
            selectOption.appendChild(option);
            return;
        }

        const fragment = document.createDocumentFragment();
        for (const movie of movies) {
            const option = document.createElement('option');
            option.value = movie.ElokuvaID;
            option.textContent = movie.Nimi;
            fragment.appendChild(option);
        }
        selectOption.appendChild(fragment);

    } catch (error) {
        console.error('FetchMovies Error:', error);
    }
};

const deleteMovie = async (movieId) => {
   try {
        const response = await fetch(`./../api/deleteMovie.php?movieId=${encodeURIComponent(movieId)}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-Token': window.csrfToken
            }
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            alert('Error: ' + (errorData.message || 'Server error'));
            return;
        }

        const data = await response.json();

        if (data.success) {
            alert(data.message || 'Movie deleted successfully!');
            fetchRentedMovies(); 
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }

    } catch (error) {
        console.error('DeleteMovie Error:', error);
        alert('There was a problem with the request.');
    }
};


const fetchRentedMovies = async () => {
    try {
        const response = await fetch('./../api/fetchRentedMovies.php', { method: 'GET' });

        if (!response.ok) {
            console.error('Failed to fetch rented movies');
            return;
        }


        const data = await response.json();
        const movies = data.data || [];

        rentedMoviesContainer.innerHTML = '';

        if (movies.length === 0) {
            console.log('movies', movies);
            rentedMoviesContainer.textContent = 'You have not rented any movies yet.';
            return;
        }

        const ul = document.createElement('ul');
        movies.forEach(movie => {
            //Lista elementti
            const li = document.createElement('li');
            li.textContent = `${movie.Nimi}  (palautus: ${movie.PalautusPVM})`;

            //Lisätään poista linkki
            const deleteLink = document.createElement('a');
            deleteLink.addEventListener('click', (e) => {
                e.preventDefault();
                deleteMovie(movie.ElokuvaID);
            });
            deleteLink.href = '#';
            deleteLink.textContent = 'Poista';

            li.appendChild(deleteLink);
            ul.appendChild(li);
        });

        rentedMoviesContainer.appendChild(ul);

    } catch (error) {
        console.error('FetchRentedMovies Error:', error);
    }
};

fetchMovies();
fetchRentedMovies();

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
        const response = await fetch('./../api/rentMovie.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            alert('Error: ' + (errorData.message || 'Server error'));
            return;
        }

        const data = await response.json();

        if (data.success) {
            alert('Movie rented successfully!');
            form.reset();

            // ✅ Refresh both lists
            fetchMovies();          // Update available movies
            fetchRentedMovies();    // Update rented movies list
        } else {
            alert('Error: ' + (data.message || 'Unknown error'));
        }

    } catch (error) {
        console.error('Form submission error:', error);
        alert('There was a problem with the request.');
    }
});

document.getElementById('logoutBtn').addEventListener('click', async () => {
    await fetch('./../api/logout.php');
    window.location.href = './../index.php';
});
