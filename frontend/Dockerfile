# frontend/Dockerfile
FROM node:18-alpine as builder

WORKDIR /app

COPY . .

RUN npm install && npm run build-only --if-present || npm run build --if-present

# Serve with Nginx
FROM nginx:stable-alpine

COPY --from=builder /app/dist /usr/share/nginx/html

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]