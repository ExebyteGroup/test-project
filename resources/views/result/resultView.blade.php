@extends('layout')
@section('content')
    <div class="result_parameter_table_class">
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($result_parameters as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td class="limited-characters">{{ $item->description }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td style="float: right;display: flex;">
                        <a href="{{ url("result-parameter/update/$item->id") }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ url("result-parameter/delete/$item->id") }}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="add_result_class">
            <a href="/result-parameter/create" class="btn btn-primary add_class">Add Result Parameter</a>
        </div>
    </div>

    <script>
        // Get all table cells with the class 'limited-characters'
        const limitedCells = document.querySelectorAll('.limited-characters');
        // Loop through each cell and limit the number of characters
        limitedCells.forEach((cell) => {
            // Get the text content of the cell
            const textContent = cell.textContent.trim();
            // Set the maximum number of characters to show
            const maxCharacters = 50;
            // Check if the text content is longer than the maximum
            if (textContent.length > maxCharacters) {
                // Get the limited text content
                const limitedText = textContent.substring(0, maxCharacters) + '...';
                // Replace the cell's text content with the limited text
                cell.textContent = limitedText;
                // Add an expand button to show the full text
                const expandButton = document.createElement('a');
                expandButton.href = '#';
                expandButton.classList.add('expand-button');
                expandButton.textContent = 'Show more';
                expandButton.addEventListener('click', (event) => {
                    event.preventDefault();
                    // Check if the cell already has the full text content
                    if (cell.textContent.trim() === textContent) {
                        // Replace the cell's text content with the limited text
                        cell.textContent = limitedText;
                        // Change the expand button text to 'Show more'
                        expandButton.textContent = 'Show more';
                        // Add the expand button back
                        cell.appendChild(expandButton);
                        // Remove the show less button
                        cell.removeChild(showLessButton);
                    } else {
                        // Replace the cell's text content with the full text
                        cell.textContent = textContent;
                        // Change the expand button text to 'Show less'
                        expandButton.textContent = 'Show less';
                        // Add a show less button to hide the full text
                        const showLessButton = document.createElement('a');
                        showLessButton.href = '#';
                        showLessButton.classList.add('show-less-button');
                        showLessButton.textContent = 'Show less';
                        showLessButton.addEventListener('click', (event) => {
                            event.preventDefault();
                            // Replace the cell's text content with the limited text
                            cell.textContent = limitedText;
                            // Change the expand button text to 'Show more'
                            expandButton.textContent = 'Show more';
                            // Add the expand button back
                            cell.appendChild(expandButton);
                            // Remove the show less button
                            cell.removeChild(showLessButton);
                        });
                        // Add the show less button after the expand button
                        cell.insertBefore(showLessButton, expandButton.nextSibling);
                        // Remove the expand button
                        cell.removeChild(expandButton);
                    }
                });
                // Add the expand button to the cell if the text content is longer than the maximum
                cell.appendChild(expandButton);
            }
        });
    </script>
@endsection
