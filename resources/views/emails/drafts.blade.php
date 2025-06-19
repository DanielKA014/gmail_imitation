<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Draft Emails</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: 30px auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }
        .success {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Draft Emails</h2>

    <div class="mb-3">
        <strong>Drafts:</strong> 3 |
        <strong>Sent:</strong> 5 |
        <strong>Favorites:</strong> 2
    </div>
    <div class="success">Email berhasil disimpan sebagai draft.</div>
    <table>
        <thead>
            <tr>
                <th>To</th>
                <th>Subject</th>
                <th>Body</th>
                <th>Created At</th>
                <th>Attachment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>example@example.com</td>
                <td>Subject 1</td>
                <td>This is a preview of the email body content...</td>
                <td>19 Jun 2025 14:30</td>
                <td><img src="storage/uploads/file1.jpg" width="100" alt="attachment"></td>
            </tr>
            <tr>
                <td>user@domain.com</td>
                <td>Another Subject</td>
                <td>This is another body of a draft email...</td>
                <td>19 Jun 2025 10:15</td>
                <td>-</td>
            </tr>
            <!-- Tambah baris lainnya sesuai data -->
        </tbody>
    </table>
</div>

</body>
</html>
