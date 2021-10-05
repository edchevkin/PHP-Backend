curl -v --request POST \
  --url 'http://localhost:8005/user_input/user_input.php?page=page1' \
  --header 'Content-Type: multipart/form-data; boundary=---011000010111000001101001' \
  --header 'X_Access_Token: SECRET_TOKEN' \
  --form var1=1 \
  --form var2=2 \
  --form var3=3