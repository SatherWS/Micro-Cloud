import smtplib, sys

gmail_user = 'swoopctms@gmail.com'
gmail_password = 'qlfwsrjhrzzbfknk'
receiver = sys.argv[1]
deadline = "\nDeadline: "+ sys.argv[4]
message = 'Subject: {}\n\n{}'.format(sys.argv[2], sys.argv[3]+deadline)

try:
    server = smtplib.SMTP_SSL('smtp.gmail.com', 465)
    server.ehlo()
    server.login(gmail_user, gmail_password)
    print("Connection is good")
except:
    print('Something went wrong...')

try:
    server.sendmail(gmail_user, receiver, message)
    print("Message sent!")
    server.close()
except:
    print("message did not send...")
