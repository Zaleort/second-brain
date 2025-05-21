package com.zaleort.second_brain.Shared.Infrastructure.JwtManager

import com.zaleort.second_brain.Shared.Domain.JwtManager.JwtManagerInterface
import com.zaleort.second_brain.Shared.Domain.JwtManager.JwtPayload
import io.jsonwebtoken.Jwts
import io.jsonwebtoken.security.Keys
import org.springframework.beans.factory.annotation.Value
import org.springframework.stereotype.Service
import java.util.Date

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
}