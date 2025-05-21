FROM node:22.1.0-alpine

WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./
RUN npm install --production

# Copy rest of the code
COPY . .

EXPOSE 3000

CMD ["node", "index.js"]
