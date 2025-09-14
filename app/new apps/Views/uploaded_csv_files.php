<table>
    <thead>
        <tr>
            <th>File Name</th>
            <th>Status</th>
            <th>Uploaded At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($uploadedFiles as $file): ?>
            <tr>
                <td><?= $file['file_name']; ?></td>
                <td><?= $file['active']; ?></td>
                <td><?= $file['created_at']; ?></td>
                <td>
                    <?php if ($file['active'] === 'active'): ?>
                        <button disabled>Active</button>
                    <?php else: ?>
                        <a href="<?= site_url('course/deleteCSV/' . $file['csv_id']); ?>">Delete</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
