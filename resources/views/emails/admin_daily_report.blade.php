<!DOCTYPE html>
<html>
<head>
    <title>Daily Email Report</title>
</head>
<body>
    <h2>Daily Email Report - {{ $report->report_date }}</h2>
    <p>Total Emails: {{ $report->total_email }}</p>
    <p>Success Emails: {{ $report->success_email }}</p>
    <p>Failed Emails: {{ $report->failed_email }}</p>
</body>
</html>
