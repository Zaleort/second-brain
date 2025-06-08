package com.zaleort.second_brain.Shared.Infrastructure.JwtManager

import com.zaleort.second_brain.Shared.Domain.JwtManager.JwtManagerInterface
import com.zaleort.second_brain.Shared.Domain.JwtManager.JwtPayload
import io.jsonwebtoken.ExpiredJwtException
import io.jsonwebtoken.Jwts
import io.jsonwebtoken.security.Keys
import org.springframework.beans.factory.annotation.Value
import org.springframework.stereotype.Service
import java.util.*

@Service
class JwtManager(
    @Value("\${jwt.secret}")
    private val secret: String,
    @Value("\${jwt.expiration}")
    private val expiration: Long,
) : JwtManagerInterface {
    override fun encode(payload: JwtPayload): String {
        val key = Keys.hmacShaKeyFor(secret.toByteArray())

        val token = Jwts.builder()
            .subject(payload.id)
            .issuedAt(Date())
            .expiration(Date(System.currentTimeMillis() + expiration))
            .signWith(key)
            .compact()

        return token
    }

    override fun decode(token: String): JwtPayload {
        val secretKey = Keys.hmacShaKeyFor(secret.toByteArray())

        val claims = Jwts.parser()
            .verifyWith(secretKey)
            .build()
            .parseSignedClaims(token)
            .payload

        return JwtPayload(id = claims.subject)
    }

    override fun renewToken(token: String): String {
        try {
            // Intentamos decodificar primero para validar el token
            val payload = decode(token)
            // Si el token es válido, generamos uno nuevo con el mismo ID
            return encode(payload)
        } catch (e: ExpiredJwtException) {
            // Si el token está expirado, intentamos extraer el ID del sujeto
            val claims = e.claims
            val userId = claims.subject
            // Generamos un nuevo token con el ID extraído
            return encode(JwtPayload(id = userId))
        }
    }
}