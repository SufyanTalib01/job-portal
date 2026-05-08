<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>New Job Application</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 10px;">

        <h2 style="color: #333333;">
            New Job Application Received
        </h2>

        <p style="font-size: 15px; color: #555;">
            Dear {{ $mailData['employer']->name }},
        </p>

        <p style="font-size: 15px; color: #555;">
            A new candidate has applied for your job posting.
        </p>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px;">

            <h3 style="margin-top: 0; color: #222;">Job Details</h3>

            <p>
                <strong>Job Title:</strong>
                {{ $mailData['job']->title }}
            </p>

            <p>
                <strong>Location:</strong>
                {{ $mailData['job']->location }}
            </p>

            <p>
                <strong>Salary:</strong>
                {{ $mailData['job']->salary }}
            </p>

        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-top: 20px;">

            <h3 style="margin-top: 0; color: #222;">Applicant Details</h3>

            <p>
                <strong>Name:</strong>
                {{ $mailData['user']->name }}
            </p>

            <p>
                <strong>Email:</strong>
                {{ $mailData['user']->email }}
            </p>
            <p>
                <strong>Mobile:</strong>
                {{ $mailData['user']->mobile }}
            </p>

        </div>

        <p style="margin-top: 30px; font-size: 15px; color: #555;">
            Please log in to your account to review the application.
        </p>

        <p style="margin-top: 40px; color: #777;">
            Regards,<br>
            {{ config('app.name') }}
        </p>

    </div>

</body>

</html>
