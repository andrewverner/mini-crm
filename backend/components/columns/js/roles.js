$(function () {
    $(document).on('change', 'select.roles-list', function (e) {
        e.preventDefault();

        let $node = $(this);
        $node.attr('disabled', 'true');

        $.ajax({
            url: '/user/assign-role',
            method: 'POST',
            data: {
                id: $node.data('user'),
                role: $node.val()
            },
            statusCode: {
                200: function () {
                    alert('Role has been assigned/revoked');
                },
                403: function () {
                    alert('You are not allowed to perform this action');
                },
                404: function () {
                    alert('Role or user not found');
                },
                409: function () {
                    alert('User already has a role or you try to assign a role to yourself');
                }
            },
            error: function () {
                alert('An error occurred');
            },
            complete: function () {
                $node.removeAttr('disabled');
            }
        });
    });
});
