curl -v --request POST \
  --url 'http://localhost:8005/user_input/user_input.php?page=page1' \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --header 'X_Access_Token: SECRET_TOKEN' \
  --data var1=1 \
  --data var2=2 \
  --data var3=3